<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MouvementCaisse;

class CaissierController extends Controller
{
    /**
     * Affiche le tableau de bord du caissier.
     */
    public function dashboard()
    {
        $solde = MouvementCaisse::getSoldeActuel(); // méthode statique à créer ou déjà existante
        $entreesAujourdhui = MouvementCaisse::entreesDuJour(); // idem
        $sortiesAujourdhui = MouvementCaisse::sortiesDuJour(); // idem
        $mouvements = MouvementCaisse::whereDate('created_at', today())->get();

        return view('caissier.dashboard', compact(
            'solde',
            'entreesAujourdhui',
            'sortiesAujourdhui',
            'mouvements'
        ));
    }
}
