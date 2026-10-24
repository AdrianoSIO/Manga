<?php

namespace App\Http\Controllers;

use App\Models\CategorieProjet;
use App\Models\ElementProjet;
use App\Models\PossibiliteProjet;
use App\Models\Projet;
use App\Models\TypeProjet;
use Illuminate\Http\Request;

class ProjetController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Projets
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $projets = Projet::query()
            ->where('user_id', $request->user()->id)
            ->withCount('possibilites')
            ->orderByDesc('created_at')
            ->get();

        return view('projets.index', compact('projets'));
    }

    public function create(Request $request)
    {
        $types = TypeProjet::query()
            ->where('user_id', $request->user()->id)
            ->orderBy('nom')
            ->get();

        return view('projets.create', compact('types'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateProjet($request);

        $projet = Projet::create([
            'user_id' => $request->user()->id,
            ...$validated,
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

    public function edit(Request $request, Projet $projet)
    {
        $this->authorizeProjet($request, $projet);

        $types = TypeProjet::query()
            ->where('user_id', $request->user()->id)
            ->orderBy('nom')
            ->get();

        return view('projets.edit', compact('projet', 'types'));
    }

    public function update(Request $request, Projet $projet)
    {
        $this->authorizeProjet($request, $projet);

        $validated = $this->validateProjet($request);

        $projet->update($validated);

        return redirect()
            ->route('projets.show', $projet)
            ->with('success', 'Projet modifié.');
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
    | Types de projet
    |--------------------------------------------------------------------------
    */

    public function storeType(Request $request)
    {
        $validated = $request->validate([
            'nom' => [
                'required',
                'string',
                'max:100',
            ],
        ]);

        $nom = trim($validated['nom']);

        TypeProjet::firstOrCreate([
            'user_id' => $request->user()->id,
            'nom' => $nom,
        ]);

        return back()
            ->with('success', 'Type de projet ajouté.')
            ->with('nouveau_type', $nom);
    }

    public function destroyType(
        Request $request,
        TypeProjet $typeProjet
    ) {
        abort_unless(
            $typeProjet->user_id === $request->user()->id,
            403
        );

        $typeProjet->delete();

        return back()
            ->with('success', 'Type de projet supprimé.');
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

    public function editPossibilite(
        Request $request,
        Projet $projet,
        PossibiliteProjet $possibilite
    ) {
        $this->authorizePossibilite(
            $request,
            $projet,
            $possibilite
        );

        return view(
            'projets.possibilites.edit',
            compact('projet', 'possibilite')
        );
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
                'in:a_etudier,favori,choisie,ecartee',
            ],
        ]);

        $possibilite->update($validated);

        return redirect()
            ->route('projets.show', $projet)
            ->with('success', 'Possibilité modifiée.');
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
    | Catégories
    |--------------------------------------------------------------------------
    */

    public function storeCategorie(
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
        ]);

        $possibilite->categories()->create([
            'nom' => $validated['nom'],
        ]);

        return redirect()
            ->route('projets.show', $projet)
            ->with('success', 'Catégorie ajoutée.');
    }

    public function destroyCategorie(
        Request $request,
        Projet $projet,
        PossibiliteProjet $possibilite,
        CategorieProjet $categorie
    ) {
        $this->authorizeCategorie(
            $request,
            $projet,
            $possibilite,
            $categorie
        );

        $categorie->delete();

        return redirect()
            ->route('projets.show', $projet)
            ->with('success', 'Catégorie supprimée.');
    }

    /*
    |--------------------------------------------------------------------------
    | Éléments
    |--------------------------------------------------------------------------
    */

    public function storeElement(
        Request $request,
        Projet $projet,
        PossibiliteProjet $possibilite,
        CategorieProjet $categorie
    ) {
        $this->authorizeCategorie(
            $request,
            $projet,
            $possibilite,
            $categorie
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
            'prix' => [
                'required',
                'numeric',
                'min:0',
                'max:99999999.99',
            ],
            'quantite' => [
                'required',
                'integer',
                'min:1',
                'max:9999',
            ],
            'url' => [
                'nullable',
                'url',
                'max:5000',
            ],
        ]);

        $categorie->elements()->create([
            'nom' => $validated['nom'],
            'description' => $validated['description'] ?? null,
            'prix' => $validated['prix'],
            'quantite' => $validated['quantite'],
            'url' => $validated['url'] ?? null,
            'selectionne' => false,
        ]);

        return redirect()
            ->route('projets.show', $projet)
            ->with('success', 'Élément ajouté.');
    }

    public function updateElement(
        Request $request,
        Projet $projet,
        PossibiliteProjet $possibilite,
        CategorieProjet $categorie,
        ElementProjet $element
    ) {
        $this->authorizeElement(
            $request,
            $projet,
            $possibilite,
            $categorie,
            $element
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
            'prix' => [
                'required',
                'numeric',
                'min:0',
                'max:99999999.99',
            ],
            'quantite' => [
                'required',
                'integer',
                'min:1',
                'max:9999',
            ],
            'url' => [
                'nullable',
                'url',
                'max:5000',
            ],
        ]);

        $element->update([
            'nom' => $validated['nom'],
            'description' => $validated['description'] ?? null,
            'prix' => $validated['prix'],
            'quantite' => $validated['quantite'],
            'url' => $validated['url'] ?? null,
        ]);

        return redirect()
            ->route('projets.show', $projet)
            ->with('success', 'Élément modifié.');
    }

    public function toggleElement(
        Request $request,
        Projet $projet,
        PossibiliteProjet $possibilite,
        CategorieProjet $categorie,
        ElementProjet $element
    ) {
        $this->authorizeElement(
            $request,
            $projet,
            $possibilite,
            $categorie,
            $element
        );

        $element->update([
            'selectionne' => ! $element->selectionne,
        ]);

        return redirect()
            ->route('projets.show', $projet)
            ->with(
                'success',
                $element->selectionne
                    ? 'Élément sélectionné.'
                    : 'Élément désélectionné.'
            );
    }

    public function destroyElement(
        Request $request,
        Projet $projet,
        PossibiliteProjet $possibilite,
        CategorieProjet $categorie,
        ElementProjet $element
    ) {
        $this->authorizeElement(
            $request,
            $projet,
            $possibilite,
            $categorie,
            $element
        );

        $element->delete();

        return redirect()
            ->route('projets.show', $projet)
            ->with('success', 'Élément supprimé.');
    }

    /*
    |--------------------------------------------------------------------------
    | Validation projet
    |--------------------------------------------------------------------------
    */

    private function validateProjet(Request $request): array
    {
        return $request->validate([
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

            'type' => [
                'nullable',
                'string',
                'max:100',
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
        $this->authorizeProjet(
            $request,
            $projet
        );

        abort_unless(
            $possibilite->projet_id === $projet->id,
            403
        );
    }

    private function authorizeCategorie(
        Request $request,
        Projet $projet,
        PossibiliteProjet $possibilite,
        CategorieProjet $categorie
    ): void {
        $this->authorizePossibilite(
            $request,
            $projet,
            $possibilite
        );

        abort_unless(
            $categorie->possibilite_projet_id === $possibilite->id,
            403
        );
    }

    private function authorizeElement(
        Request $request,
        Projet $projet,
        PossibiliteProjet $possibilite,
        CategorieProjet $categorie,
        ElementProjet $element
    ): void {
        $this->authorizeCategorie(
            $request,
            $projet,
            $possibilite,
            $categorie
        );

        abort_unless(
            $element->categorie_projet_id === $categorie->id,
            403
        );
    }
}