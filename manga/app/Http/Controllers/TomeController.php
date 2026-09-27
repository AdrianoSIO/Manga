<?php

namespace App\Http\Controllers;

use App\Models\Manga;
use App\Models\Tome;
use Illuminate\Http\Request;

class TomeController extends Controller
{
    /**
     * Formulaire d'ajout d'un tome.
     */
    public function create()
    {
        $mangas = Manga::orderBy('titre')->get();

        return view('tomes.create', compact('mangas'));
    }

    /**
     * Ajoute un exemplaire physique.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'manga_id' => ['required', 'exists:mangas,id'],
            'numero' => ['required', 'integer', 'min:0'],
        ]);

        Tome::create([
            'manga_id' => $validated['manga_id'],
            'user_id' => $request->user()->id,
            'numero' => $validated['numero'],
        ]);

        return redirect()
            ->route('collection.show', $validated['manga_id'])
            ->with('success', 'Tome ajouté à ta collection.');
    }

    /**
     * Supprime UN exemplaire physique.
     */
    public function destroy(Request $request, Tome $tome)
    {
        abort_unless(
            $tome->user_id === $request->user()->id,
            403
        );

        $tome->delete();

        return back()
            ->with('success', 'Exemplaire supprimé de ta collection.');
    }
}