<?php

namespace App\Http\Controllers;

use App\Models\Manga;
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

        $totalExemplaires = $user->tomes()->count();

        $totalLicences = $mangas->count();

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
}