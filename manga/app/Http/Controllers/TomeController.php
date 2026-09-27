<?php

namespace App\Http\Controllers;

use App\Models\Manga;
use App\Models\Tome;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TomeController extends Controller
{
    public function create()
    {
        $mangas = Manga::orderBy('titre')->get();

        return view('tomes.create', compact('mangas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'manga_id' => [
                'required',
                'integer',
                'exists:mangas,id',
            ],
            'numeros' => [
                'required',
                'string',
                'max:1000',
            ],
        ]);

        $numeros = $this->parseNumeros($validated['numeros']);

        if (empty($numeros)) {
            throw ValidationException::withMessages([
                'numeros' => 'Entre au moins un numéro de tome valide.',
            ]);
        }

        // Protection contre une saisie accidentellement énorme.
        if (count($numeros) > 200) {
            throw ValidationException::withMessages([
                'numeros' => 'Tu peux ajouter au maximum 200 tomes à la fois.',
            ]);
        }

        foreach ($numeros as $numero) {
            Tome::create([
                'manga_id' => $validated['manga_id'],
                'user_id' => $request->user()->id,
                'numero' => $numero,
            ]);
        }

        $nombre = count($numeros);

        return redirect()
            ->route('collection.show', $validated['manga_id'])
            ->with(
                'success',
                $nombre > 1
                    ? "{$nombre} tomes ajoutés à ta collection."
                    : 'Tome ajouté à ta collection.'
            );
    }

    public function destroy(Request $request, Tome $tome)
    {
        abort_unless(
            $tome->user_id === $request->user()->id,
            403
        );

        $tome->delete();

        return back()->with(
            'success',
            'Exemplaire supprimé de ta collection.'
        );
    }

    private function parseNumeros(string $input): array
    {
        // Autorise les espaces :
        // "1, 2, 5-8"
        $input = str_replace(' ', '', $input);

        $parties = explode(',', $input);

        $numeros = [];

        foreach ($parties as $partie) {

            if ($partie === '') {
                continue;
            }

            /*
             * Numéro simple
             *
             * Exemple :
             * 5
             */
            if (preg_match('/^\d+$/', $partie)) {
                $numeros[] = (int) $partie;
                continue;
            }

            /*
             * Intervalle
             *
             * Exemple :
             * 10-15
             */
            if (preg_match('/^(\d+)-(\d+)$/', $partie, $matches)) {

                $debut = (int) $matches[1];
                $fin = (int) $matches[2];

                if ($debut > $fin) {
                    throw ValidationException::withMessages([
                        'numeros' => "Intervalle invalide : {$partie}.",
                    ]);
                }

                // Évite par exemple 1-999999
                if (($fin - $debut) > 200) {
                    throw ValidationException::withMessages([
                        'numeros' => "Intervalle trop grand : {$partie}.",
                    ]);
                }

                foreach (range($debut, $fin) as $numero) {
                    $numeros[] = $numero;
                }

                continue;
            }

            /*
             * Si ce n'est ni un numéro,
             * ni un intervalle.
             */
            throw ValidationException::withMessages([
                'numeros' => "Format invalide : {$partie}.",
            ]);
        }

        return $numeros;
    }
}