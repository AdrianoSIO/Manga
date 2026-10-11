<?php

namespace App\Http\Controllers;

use App\Models\Manga;
use App\Models\OffreTome;
use App\Models\Tome;
use App\Models\TomeRecherche;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function create(Request $request)
    {
        $mangas = Manga::orderBy('titre')->get();

        return view('achats.create', compact('mangas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'manga_id' => ['required', 'exists:mangas,id'],
            'numero' => ['required', 'integer', 'min:1'],
        ]);

        $exists = TomeRecherche::where('user_id', $request->user()->id)
            ->where('manga_id', $validated['manga_id'])
            ->where('numero', $validated['numero'])
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors([
                    'numero' => 'Ce tome est déjà dans ta liste d’achats.',
                ]);
        }

        TomeRecherche::create([
            'user_id' => $request->user()->id,
            'manga_id' => $validated['manga_id'],
            'numero' => $validated['numero'],
        ]);

        return redirect()
            ->route('achats.index')
            ->with('success', 'Tome ajouté à la liste d’achats.');
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

    public function storeOffre(Request $request, TomeRecherche $tomeRecherche)
    {
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

    public function destroyOffre(Request $request, OffreTome $offre)
    {
        $offre->load('tomeRecherche');

        $this->authorizeTome($request, $offre->tomeRecherche);

        $offre->delete();

        return back()->with('success', 'Offre supprimée.');
    }

    public function acheter(Request $request, TomeRecherche $tomeRecherche)
    {
        $this->authorizeTome($request, $tomeRecherche);

        $mangaId = $tomeRecherche->manga_id;

        DB::transaction(function () use ($request, $tomeRecherche) {
            Tome::create([
                'user_id' => $request->user()->id,
                'manga_id' => $tomeRecherche->manga_id,
                'numero' => $tomeRecherche->numero,
            ]);

            $tomeRecherche->delete();
        });

        $reste = TomeRecherche::where('user_id', $request->user()->id)
            ->where('manga_id', $mangaId)
            ->exists();

        if (!$reste) {
            return redirect()
                ->route('collection.show', $mangaId)
                ->with('success', 'Licence complétée dans ta liste d’achats. Tome ajouté à ta collection.');
        }

        return back()->with('success', 'Tome ajouté à ta collection.');
    }

    public function destroy(Request $request, TomeRecherche $tomeRecherche)
    {
        $this->authorizeTome($request, $tomeRecherche);

        $tomeRecherche->delete();

        return back()->with('success', 'Tome retiré de la liste d’achats.');
    }

    private function authorizeTome(Request $request, TomeRecherche $tomeRecherche): void
    {
        abort_unless(
            $tomeRecherche->user_id === $request->user()->id,
            403
        );
    }
}