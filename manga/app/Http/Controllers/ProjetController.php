<?php

namespace App\Http\Controllers;

use App\Models\PossibiliteProjet;
use App\Models\Projet;
use Illuminate\Http\Request;

class ProjetController extends Controller
{
    public function index(Request $request)
    {
        $projets = Projet::query()
            ->where('user_id', $request->user()->id)
            ->withCount('possibilites')
            ->orderByDesc('created_at')
            ->get();

        return view('projets.index', compact('projets'));
    }

    public function create()
    {
        return view('projets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => [
                'nullable',
                'string',
                'max:5000',
            ],
            'budget' => [
                'required',
                'numeric',
                'min:0',
                'max:99999999.99',
            ],
            'date_debut' => [
                'nullable',
                'date',
            ],
            'date_fin' => [
                'nullable',
                'date',
                'after_or_equal:date_debut',
            ],
        ]);

        $projet = Projet::create([
            'user_id' => $request->user()->id,
            'nom' => $validated['nom'],
            'description' => $validated['description'] ?? null,
            'budget' => $validated['budget'],
            'date_debut' => $validated['date_debut'] ?? null,
            'date_fin' => $validated['date_fin'] ?? null,
        ]);

        return redirect()
            ->route('projets.show', $projet)
            ->with('success', 'Projet créé.');
    }

    public function show(Request $request, Projet $projet)
    {
        $this->authorizeProjet($request, $projet);

        $projet->load([
            'possibilites' => function ($query) {
                $query
                    ->with([
                        'budget',
                        'categories.elements',
                    ])
                    ->orderBy('created_at');
            },
        ]);

        return view('projets.show', compact('projet'));
    }

    public function destroy(Request $request, Projet $projet)
    {
        $this->authorizeProjet($request, $projet);

        $projet->delete();

        return redirect()
            ->route('projets.index')
            ->with('success', 'Projet supprimé.');
    }

    /*
    |--------------------------------------------------------------------------
    | Possibilités
    |--------------------------------------------------------------------------
    */

    public function storePossibilite(
        Request $request,
        Projet $projet
    ) {
        $this->authorizeProjet($request, $projet);

        $validated = $request->validate([
            'nom' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => [
                'nullable',
                'string',
                'max:5000',
            ],
        ]);

        $projet->possibilites()->create([
            'nom' => $validated['nom'],
            'description' => $validated['description'] ?? null,
            'statut' => 'a_etudier',
        ]);

        return redirect()
            ->route('projets.show', $projet)
            ->with('success', 'Possibilité ajoutée.');
    }

    public function updatePossibilite(
        Request $request,
        Projet $projet,
        PossibiliteProjet $possibilite
    ) {
        $this->authorizePossibilite(
            $request,
            $projet,
            $possibilite
        );

        $validated = $request->validate([
            'nom' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => [
                'nullable',
                'string',
                'max:5000',
            ],
            'statut' => [
                'required',
                'in:a_etudier,favori,ecartee,choisie',
            ],
        ]);

        $possibilite->update($validated);

        return redirect()
            ->route('projets.show', $projet)
            ->with('success', 'Possibilité mise à jour.');
    }

    public function destroyPossibilite(
        Request $request,
        Projet $projet,
        PossibiliteProjet $possibilite
    ) {
        $this->authorizePossibilite(
            $request,
            $projet,
            $possibilite
        );

        $possibilite->delete();

        return redirect()
            ->route('projets.show', $projet)
            ->with('success', 'Possibilité supprimée.');
    }

    /*
    |--------------------------------------------------------------------------
    | Autorisations
    |--------------------------------------------------------------------------
    */

    private function authorizeProjet(
        Request $request,
        Projet $projet
    ): void {
        abort_unless(
            $projet->user_id === $request->user()->id,
            403
        );
    }

    private function authorizePossibilite(
        Request $request,
        Projet $projet,
        PossibiliteProjet $possibilite
    ): void {
        $this->authorizeProjet($request, $projet);

        abort_unless(
            $possibilite->projet_id === $projet->id,
            403
        );
    }
}