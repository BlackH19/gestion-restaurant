<?php

namespace App\Http\Controllers;

use App\Models\Plat;
use App\Models\Commande;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlatController extends Controller
{
    public function index()
    {
        $plats = Plat::with([
            'ingredients',
            'commandes' => function ($query) {
                $query->select('commandes.id', 'date_heure')
                    ->withPivot('quantite');
            }
        ])
            ->latest()
            ->paginate(20);

        return view('plats.index', compact('plats'));
    }

    public function create()
    {
        $ingredients = Ingredient::all();
        return view('plats.create', compact('ingredients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_plat' => 'required|string|max:255',
            'prix_unitaire' => 'required|numeric|min:0',
            'ingredients' => 'sometimes|array',
            'ingredients.*.id' => 'required_with:ingredients|exists:ingredients,id',
            'ingredients.*.quantite' => 'required_with:ingredients|numeric|min:0'
        ]);

        return DB::transaction(function () use ($validated) {
            $plat = Plat::create([
                'nom_plat' => $validated['nom_plat'],
                'prix_unitaire' => $validated['prix_unitaire']
            ]);

            if (isset($validated['ingredients'])) {
                $this->syncIngredients($plat, $validated['ingredients']);
            }

            return redirect()
                ->route('plats.index')
                ->with('success', 'Plat créé avec succès.');
        });
    }

    public function show(Plat $plat)
    {
        $plat->load(['ingredients', 'commandes']);
        return view('plats.show', compact('plat'));
    }

    public function edit(Plat $plat)
    {
        $commandes = Commande::select('id', 'date_heure')->latest()->get();
        $ingredients = Ingredient::all();

        return view('plats.edit', [
            'plat' => $plat->load('ingredients'),
            'ingredients' => $ingredients,
            'commandes' => $commandes
        ]);
    }

    public function update(Request $request, Plat $plat)
    {
        $validated = $request->validate([
            'nom_plat' => 'required|string|max:255',
            'prix_unitaire' => 'required|numeric|min:0',
            'ingredients' => 'sometimes|array',
            'ingredients.*.id' => 'required_with:ingredients|exists:ingredients,id',
            'ingredients.*.quantite' => 'required_with:ingredients|numeric|min:0'
        ]);

        $plat->update([
            'nom_plat' => $validated['nom_plat'],
            'prix_unitaire' => $validated['prix_unitaire']
        ]);

        if (isset($validated['ingredients'])) {
            $this->syncIngredients($plat, $validated['ingredients']);
        }

        return redirect()
            ->route('plats.index')
            ->with('success', 'Plat mis à jour avec succès.');
    }

    public function destroy(Plat $plat)
    {
        DB::transaction(function () use ($plat) {
            $plat->ingredients()->detach();
            $plat->delete();
        });

        return redirect()
            ->route('plats.index')
            ->with('success', 'Plat supprimé avec succès.');
    }

    protected function syncIngredients(Plat $plat, array $ingredients): void
    {
        $ingredientsData = collect($ingredients)->mapWithKeys(function ($item) {
            return [
                $item['id'] => [
                    'quantite' => $item['quantite'],
                    'unite' => $item['unite'] ?? 'g' // Valeur par défaut 'g' si non fournie
                ]
            ];
        })->toArray();

        $plat->ingredients()->sync($ingredientsData);
    }
}