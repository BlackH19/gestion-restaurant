<?php
namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    public function index()
    {
        $ingredients = Ingredient::all();
        return view('ingredients.index', compact('ingredients'));
    }

    public function create()
    {
        return view('ingredients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'quantite_stock' => 'required|numeric|min:0',
            'unite' => 'required|string|max:10',
            'prix_unitaire' => 'required|numeric|min:0',
        ]);

        Ingredient::create($request->all());

        return redirect()->route('ingredients.index')->with('success', 'Ingrédient ajouté avec succès.');
    }

    public function edit(Ingredient $ingredient)
    {
        return view('ingredients.edit', compact('ingredient'));
    }

    public function update(Request $request, Ingredient $ingredient)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'quantite_stock' => 'required|numeric|min:0',
            'unite' => 'required|string|max:10',
            'prix_unitaire' => 'required|numeric|min:0',
        ]);

        $ingredient->update($request->all());

        return redirect()->route('ingredients.index')->with('success', 'Ingrédient mis à jour.');
    }

    public function show(Ingredient $ingredient)
    {
        return view('ingredients.show', compact('ingredient'));
    }

    public function destroy(Ingredient $ingredient)
    {
        $ingredient->delete();
        return redirect()->route('ingredients.index')->with('success', 'Ingrédient supprimé.');
    }
}
