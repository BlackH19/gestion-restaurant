<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\Plat;
use Illuminate\Support\Facades\Auth;

class ServeurController extends Controller
{
    /**
     * Affiche le tableau de bord serveur avec commandes et plats.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $commandes = Commande::where('serveur_id', Auth::id())
                            ->with('plats')
                            ->latest()
                            ->take(5)
                            ->get();

        $plats = Plat::where('disponible', true)->get();

        return view('serveur.dashboard', compact('commandes', 'plats'));
    }
}
