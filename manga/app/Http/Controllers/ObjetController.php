<?php

namespace App\Http\Controllers;

use App\Models\Objet;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ObjetController extends Controller
{
    public function index(Request $request)
    {
        $objets = $request->user()
            ->objets()
            ->orderByRaw("
                FIELD(importance, 'SSS', 'SS', 'S', 'A', 'B', 'C', 'D')
            ")
            ->orderByDesc('date_ajout')
            ->get();

        return view('objets.index', compact('objets'));
    }

    public function create()
    {
        return view('objets.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateObjet($request);

        $request->user()->objets()->create([
            ...$validated,
            'disponible' => $request->boolean('disponible'),
            'achete' => $request->boolean('achete'),
            'date_ajout' => now()->toDateString(),
            'date_achat' => $request->boolean('achete')
                ? ($validated['date_achat'] ?? now()->toDateString())
                : null,
        ]);

        return redirect()
            ->route('objets.index')
            ->with('success', 'Objet ajouté à ta liste.');
    }

    public function edit(Request $request, Objet $objet)
    {
        $this->authorizeObjet($request, $objet);

        return view('objets.edit', compact('objet'));
    }

    public function update(Request $request, Objet $objet)
    {
        $this->authorizeObjet($request, $objet);

        $validated = $this->validateObjet($request);

        $objet->update([
            ...$validated,
            'disponible' => $request->boolean('disponible'),
            'achete' => $request->boolean('achete'),
            'date_achat' => $request->boolean('achete')
                ? ($validated['date_achat'] ?? $objet->date_achat ?? now()->toDateString())
                : null,
        ]);

        return redirect()
            ->route('objets.index')
            ->with('success', 'Objet mis à jour.');
    }

    public function destroy(Request $request, Objet $objet)
    {
        $this->authorizeObjet($request, $objet);

        $objet->delete();

        return redirect()
            ->route('objets.index')
            ->with('success', 'Objet supprimé.');
    }

    private function validateObjet(Request $request): array
    {
        return $request->validate([
            'nom' => [
                'required',
                'string',
                'max:255',
            ],

            'categorie' => [
                'nullable',
                'string',
                'max:100',
            ],

            'prix' => [
                'nullable',
                'numeric',
                'min:0',
                'max:99999999.99',
            ],

            'prix_cible' => [
                'nullable',
                'numeric',
                'min:0',
                'max:99999999.99',
            ],

            'url' => [
                'nullable',
                'url',
                'max:2000',
            ],

            'importance' => [
                'required',
                Rule::in([
                    'SSS',
                    'SS',
                    'S',
                    'A',
                    'B',
                    'C',
                    'D',
                ]),
            ],

            'description' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'disponible' => [
                'nullable',
                'boolean',
            ],

            'achete' => [
                'nullable',
                'boolean',
            ],

            'date_achat' => [
                'nullable',
                'date',
            ],
        ]);
    }

    private function authorizeObjet(
        Request $request,
        Objet $objet
    ): void {
        abort_unless(
            $objet->user_id === $request->user()->id,
            403
        );
    }
}