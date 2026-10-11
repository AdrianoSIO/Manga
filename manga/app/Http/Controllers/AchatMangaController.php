<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Manga;
use App\Models\OffreTome;
use App\Models\Tome;
use App\Models\TomeRecherche;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AchatMangaController extends Controller
{
    public function index(Request $request)
    {
        $tomes = TomeRecherche::query()
            ->where('user_id', $request->user()->id)
            ->with(['manga.genres', 'offres'])
            ->orderBy('manga_id')
            ->orderBy('numero')
            ->get();

        $mangas = $tomes
            ->groupBy('manga_id')
            ->map(function ($tomes) {
                return [
                    'manga' => $tomes->first()->manga,
                    'tomes' => $tomes,
                ];
            });

        return view('achats.index', compact('mangas'));
    }

    public function create()
    {
        $mangas = Manga::orderBy('titre')->get();
        $genres = Genre::orderBy('nom')->get();

        return view('achats.create', compact('mangas', 'genres'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'manga_id' => ['nullable', 'integer', 'exists:mangas,id'],
            'nouveau_titre' => ['nullable', 'string', 'max:255'],
            'numeros' => ['required', 'string', 'max:1000'],
            'genres' => ['nullable', 'array'],
            'genres.*' => ['integer', 'exists:genres,id'],
        ]);

        if (!empty($validated['manga_id'])) {
            $manga = Manga::findOrFail($validated['manga_id']);
        } elseif (!empty($validated['nouveau_titre'])) {
            if (empty($validated['genres'])) {
                throw ValidationException::withMessages([
                    'genres' => 'Sélectionne au moins un genre pour une nouvelle licence.',
                ]);
            }

            $titre = trim($validated['nouveau_titre']);

            $manga = Manga::where('titre', $titre)->first();

            if (!$manga) {
                $manga = Manga::create([
                    'titre' => $titre,
                ]);

                $manga->genres()->sync($validated['genres']);
            }
        } else {
            throw ValidationException::withMessages([
                'nouveau_titre' => 'Choisis une licence existante ou indique le nom d’une nouvelle licence.',
            ]);
        }

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

        $ajoutes = 0;

        DB::transaction(function () use (
            $request,
            $manga,
            $numeros,
            &$ajoutes
        ) {
            foreach ($numeros as $numero) {
                $tome = TomeRecherche::firstOrCreate([
                    'user_id' => $request->user()->id,
                    'manga_id' => $manga->id,
                    'numero' => $numero,
                ]);

                if ($tome->wasRecentlyCreated) {
                    $ajoutes++;
                }
            }
        });

        if ($ajoutes === 0) {
            return redirect()
                ->route('achats.show', $manga)
                ->with(
                    'success',
                    'Ces tomes étaient déjà dans ta liste d’achats.'
                );
        }

        return redirect()
            ->route('achats.show', $manga)
            ->with(
                'success',
                $ajoutes > 1
                    ? "{$ajoutes} tomes ajoutés à ta liste d’achats."
                    : 'Tome ajouté à ta liste d’achats.'
            );
    }

    public function show(Request $request, Manga $manga)
    {
        $tomes = TomeRecherche::query()
            ->where('user_id', $request->user()->id)
            ->where('manga_id', $manga->id)
            ->with('offres')
            ->orderBy('numero')
            ->get();

        abort_if($tomes->isEmpty(), 404);

        return view('achats.show', compact('manga', 'tomes'));
    }

    public function storeOffre(
        Request $request,
        TomeRecherche $tomeRecherche
    ) {
        $this->authorizeTome($request, $tomeRecherche);

        $validated = $request->validate([
            'boutique' => ['required', 'string', 'max:255'],
            'prix' => ['nullable', 'numeric', 'min:0'],
            'url' => ['required', 'url', 'max:2000'],
            'disponible' => ['nullable', 'boolean'],
        ]);

        $tomeRecherche->offres()->create([
            'boutique' => $validated['boutique'],
            'prix' => $validated['prix'] ?? null,
            'url' => $validated['url'],
            'disponible' => $request->boolean('disponible'),
        ]);

        return back()->with('success', 'Offre ajoutée.');
    }

    public function destroyOffre(
        Request $request,
        OffreTome $offre
    ) {
        $offre->load('tomeRecherche');

        $this->authorizeTome(
            $request,
            $offre->tomeRecherche
        );

        $offre->delete();

        return back()->with('success', 'Offre supprimée.');
    }

    public function acheter(
        Request $request,
        TomeRecherche $tomeRecherche
    ) {
        $this->authorizeTome($request, $tomeRecherche);

        $mangaId = $tomeRecherche->manga_id;

        DB::transaction(function () use (
            $request,
            $tomeRecherche
        ) {
            Tome::create([
                'user_id' => $request->user()->id,
                'manga_id' => $tomeRecherche->manga_id,
                'numero' => $tomeRecherche->numero,
            ]);

            $tomeRecherche->delete();
        });

        $reste = TomeRecherche::where(
            'user_id',
            $request->user()->id
        )
            ->where('manga_id', $mangaId)
            ->exists();

        if (!$reste) {
            return redirect()
                ->route('collection.show', $mangaId)
                ->with(
                    'success',
                    'Tome ajouté à ta collection.'
                );
        }

        return back()->with(
            'success',
            'Tome ajouté à ta collection.'
        );
    }

    public function destroy(
        Request $request,
        TomeRecherche $tomeRecherche
    ) {
        $this->authorizeTome($request, $tomeRecherche);

        $tomeRecherche->delete();

        return back()->with(
            'success',
            'Tome retiré de la liste d’achats.'
        );
    }

    private function authorizeTome(
        Request $request,
        TomeRecherche $tomeRecherche
    ): void {
        abort_unless(
            $tomeRecherche->user_id === $request->user()->id,
            403
        );
    }

    private function parseNumeros(string $input): array
    {
        $input = str_replace(' ', '', $input);

        $parties = explode(',', $input);

        $numeros = [];

        foreach ($parties as $partie) {
            if ($partie === '') {
                continue;
            }

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

            if (
                preg_match(
                    '/^(\d+)-(\d+)$/',
                    $partie,
                    $matches
                )
            ) {
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

        $numeros = array_values(array_unique($numeros));

        sort($numeros);

        return $numeros;
    }
}