<?php

namespace App\Http\Controllers;

use App\Models\Plat;
use App\Models\Commande;
use App\Models\Ingredient;
use Illuminate\Http\Request;

class PlatController extends Controller
{
    public function index()
    {
        $plats = Plat::paginate(20); // ❌ plus de with('commande') car table pivot
        return view('plats.index', compact('plats'));
    }

    public function create()
    {
        $ingredients = Ingredient::all();
        $commandes = Commande::all();
        return view('plats.create', compact('ingredients', 'commandes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom_plat' => 'required|string|max:255',
            'quantite' => 'required|integer|min:1',
            'prix_unitaire' => 'required|numeric|min:0',
        ]);

        Plat::create($request->all());

        return redirect()->route('plats.index')->with('success', 'Plat créé avec succès.');
    }

    public function show(Plat $plat)
    {
        return view('plats.show', compact('plat'));
    }

    public function edit(Plat $plat)
    {
        $commandes = Commande::cursor(); // Utilise un curseur pour les grosses tables
        return view('plats.edit', compact('plat', 'commandes'));
    }

    public function update(Request $request, Plat $plat)
    {
        $request->validate([
            'nom_plat' => 'required|string|max:255',
            'quantite' => 'required|integer|min:1',
            'prix_unitaire' => 'required|numeric|min:0',
        ]);

        $plat->update($request->all());

        return redirect()->route('plats.index')->with('success', 'Plat mis à jour avec succès.');
    }

    public function destroy(Plat $plat)
    {
        $plat->delete();
        return redirect()->route('plats.index')->with('success', 'Plat supprimé avec succès.');
    }
}
