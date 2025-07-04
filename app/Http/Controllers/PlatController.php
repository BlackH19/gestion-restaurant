<?php

namespace App\Http\Controllers;

use App\Models\Plat;
use App\Models\Commande;
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
        $commandes = Commande::all(); // récupère les commandes
        return view('plats.create', compact('commandes')); // passe la variable à la vue
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
        return view('plats.edit', compact('plat'));
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
