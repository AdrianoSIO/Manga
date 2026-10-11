<?php

namespace App\Http\Controllers;

use App\Models\Manga;
use App\Models\StatCollection;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    /**
     * Affiche toute la collection de l'utilisateur connecté.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $mangas = Manga::query()
            ->with('genres')
            ->with([
                'tomes' => function ($query) use ($user) {
                    $query
                        ->where('user_id', $user->id)
                        ->orderBy('numero');
                }
            ])
            ->whereHas('tomes', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->orderBy('titre')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Statistiques depuis la VIEW SQL
        |--------------------------------------------------------------------------
        */

        $stats = StatCollection::where('user_id', $user->id)
            ->first();

        $totalLicences = $stats?->total_licences ?? 0;
        $totalExemplaires = $stats?->total_exemplaires ?? 0;

        return view('collection.index', compact(
            'mangas',
            'totalExemplaires',
            'totalLicences'
        ));
    }

    /**
     * Affiche un manga précis.
     */
    public function show(Request $request, Manga $manga)
    {
        $manga->load('genres');

        $tomes = $manga->tomes()
            ->where('user_id', $request->user()->id)
            ->orderBy('numero')
            ->get();

        return view('collection.show', compact(
            'manga',
            'tomes'
        ));
    }

    /**
     * Passe une licence de "En cours" à "Terminée"
     * ou de "Terminée" à "En cours".
     */
    public function toggleTerminee(Request $request, Manga $manga)
    {
        $possedeManga = $manga->tomes()
            ->where('user_id', $request->user()->id)
            ->exists();

        abort_unless($possedeManga, 403);

        $manga->update([
            'collection_terminee' => !$manga->collection_terminee,
        ]);

        return back()->with(
            'success',
            $manga->collection_terminee
                ? 'Collection marquée comme terminée.'
                : 'Collection remise en cours.'
        );
    }
}