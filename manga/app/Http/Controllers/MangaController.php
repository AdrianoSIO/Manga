<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Manga;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MangaController extends Controller
{
    /**
     * Page de création d'une nouvelle licence.
     */
    public function create()
    {
        // Récupère tous les genres de la base
        $genres = Genre::orderBy('nom')->get();

        // Envoie $genres à mangas/create.blade.php
        return view('mangas.create', [
            'genres' => $genres,
        ]);
    }

    /**
     * Enregistre une nouvelle licence.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => [
                'required',
                'string',
                'max:255',
                Rule::unique('mangas', 'titre'),
            ],

            'genres' => [
                'required',
                'array',
                'min:1',
            ],

            'genres.*' => [
                'integer',
                'exists:genres,id',
            ],
        ]);

        // Création de la licence
        $manga = Manga::create([
            'titre' => $validated['titre'],
        ]);

        // Association licence <-> genres
        $manga->genres()->sync($validated['genres']);

        // Une fois créée, on peut ajouter son premier tome
        return redirect()
            ->route('tomes.create', [
                'manga' => $manga->id,
            ])
            ->with(
                'success',
                'Licence créée. Tu peux maintenant ajouter son premier tome.'
            );
    }
}