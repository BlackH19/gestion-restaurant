<?php

namespace App\Http\Controllers;

use App\Models\MouvementCaisse;
use Illuminate\Http\Request;

class MouvementCaisseController extends Controller
{
    public function index() {
        $mouvements = MouvementCaisse::with('caissier')->latest()->paginate(10);
        return view('mouvements_caisse.index', compact('mouvements'));
    }

    public function create() {
        return view('mouvements_caisse.create');
    }

    public function store(Request $request) {
        $request->validate([
            'type' => 'required|in:entree,sortie',
            'montant' => 'required|numeric',
            'motif' => 'nullable|string',
            'caissier_id' => 'required|exists:users,id',
        ]);

        MouvementCaisse::create($request->all());

        // ✅ Rediriger vers la liste avec un message de succès
        return redirect()->route('mouvements.index')->with('success', 'Mouvement enregistré avec succès.');
    }

    public function show($id) {
        return view('mouvements_caisse.show', [
            'mouvement' => MouvementCaisse::findOrFail($id)
        ]);
    }

    public function update(Request $request, $id) {
        $mouvement = MouvementCaisse::findOrFail($id);
        $mouvement->update($request->all());

        return redirect()->route('mouvements.index')->with('success', 'Mouvement mis à jour.');
    }

    public function destroy($id) {
        MouvementCaisse::destroy($id);

        return redirect()->route('mouvements.index')->with('success', 'Mouvement supprimé.');
    }

    public function solde() {
        $totalEntrees = MouvementCaisse::where('type', 'entree')->sum('montant');
        $totalSorties = MouvementCaisse::where('type', 'sortie')->sum('montant');
        $solde = $totalEntrees - $totalSorties;

        return view('mouvements_caisse.solde', compact('totalEntrees', 'totalSorties', 'solde'));
    }

    public static function getSoldeActuel() {
        $entrees = MouvementCaisse::where('type', 'entree')->sum('montant');
        $sorties = MouvementCaisse::where('type', 'sortie')->sum('montant');
        return $entrees - $sorties;
    }

    public static function entreesDuJour() {
        return MouvementCaisse::where('type', 'entree')->whereDate('created_at', today())->sum('montant');
    }

    public static function sortiesDuJour() {
        return MouvementCaisse::where('type', 'sortie')->whereDate('created_at', today())->sum('montant');
    }
}
