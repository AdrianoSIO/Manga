<?php

namespace App\Http\Controllers;

use App\Models\Manga;
use App\Models\Tome;
use Illuminate\Http\Request;

class TomeController extends Controller
{
    public function create()
    {
        // On ne peut choisir qu'une licence qui existe déjà
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

            'numero' => [
                'required',
                'integer',
                'min:0',
            ],
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
}