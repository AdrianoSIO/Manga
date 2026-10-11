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

        $mangaId = $tome->manga_id;
        $userId = $request->user()->id;

        /*
        |--------------------------------------------------------------------------
        | Suppression de l'exemplaire physique
        |--------------------------------------------------------------------------
        |
        | On supprime uniquement le Tome.
        | Le Manga reste en base, notamment s'il est encore utilisé
        | dans la liste d'achats.
        |
        */
        $tome->delete();

        /*
        |--------------------------------------------------------------------------
        | Vérifie s'il reste des tomes physiques
        |--------------------------------------------------------------------------
        */
        $resteDesTomes = Tome::where('user_id', $userId)
            ->where('manga_id', $mangaId)
            ->exists();

        /*
        |--------------------------------------------------------------------------
        | Il reste des tomes
        |--------------------------------------------------------------------------
        |
        | La licence appartient toujours à la collection physique.
        |
        */
        if ($resteDesTomes) {
            return redirect()
                ->route('collection.show', $mangaId)
                ->with(
                    'success',
                    'Exemplaire supprimé de ta collection.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | C'était le dernier tome
        |--------------------------------------------------------------------------
        |
        | On revient à la collection générale.
        |
        | IMPORTANT :
        | on ne supprime PAS le Manga.
        | Il peut encore être référencé par tomes_recherches.
        |
        */
        return redirect()
            ->route('collection.index')
            ->with(
                'success',
                'Dernier exemplaire supprimé de ta collection.'
            );
    }

    private function parseNumeros(string $input): array
    {
        // Autorise :
        // 1
        // 1,2,5
        // 1-5
        // 1-3,7,10-12

        $input = str_replace(' ', '', $input);

        $parties = explode(',', $input);

        $numeros = [];

        foreach ($parties as $partie) {
            if ($partie === '') {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Numéro simple
            |--------------------------------------------------------------------------
            */
            if (preg_match('/^\d+$/', $partie)) {
                $numero = (int) $partie;

                if ($numero < 1) {
                    throw ValidationException::withMessages([
                        'numeros' => 'Le numéro du tome doit être supérieur à 0.',
                    ]);
                }

                $numeros[] = $numero;

                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Intervalle
            |--------------------------------------------------------------------------
            |
            | Exemple : 10-15
            |
            */
            if (preg_match('/^(\d+)-(\d+)$/', $partie, $matches)) {
                $debut = (int) $matches[1];
                $fin = (int) $matches[2];

                if ($debut < 1 || $fin < 1) {
                    throw ValidationException::withMessages([
                        'numeros' => 'Les numéros de tomes doivent être supérieurs à 0.',
                    ]);
                }

                if ($debut > $fin) {
                    throw ValidationException::withMessages([
                        'numeros' => "Intervalle invalide : {$partie}.",
                    ]);
                }

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

            throw ValidationException::withMessages([
                'numeros' => "Format invalide : {$partie}.",
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Nettoyage
        |--------------------------------------------------------------------------
        |
        | Exemple :
        | 1,2,2,3 → 1,2,3
        |
        */
        $numeros = array_values(array_unique($numeros));

        sort($numeros);

        return $numeros;
    }
}