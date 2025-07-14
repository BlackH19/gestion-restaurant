<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Plat;
use App\Models\MouvementCaisse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommandeController extends Controller
{
    public function index()
    {
        $commandes = Commande::with(['serveur', 'plats'])
            ->latest()
            ->paginate(10);

        return view('commandes.index', compact('commandes'));
    }

    public function create()
    {
        $plats = Plat::all();
        $serveurs = \App\Models\User::where('role', 'serveur')->get();

        return view('commandes.create', compact('plats', 'serveurs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date_heure' => 'required|date',
            'serveur_id' => 'required|exists:users,id',
            'plats' => 'required|array|min:1',
            'plats.*.id' => 'required|exists:plats,id',
            'plats.*.quantite' => 'required|integer|min:1',
        ]);

            $commande = Commande::create([
                'date_heure' => $validated['date_heure'],
                'serveur_id' => $validated['serveur_id'],
                'statut' => 'En_attente', // Statut initial
                'total' => 0,
            ]);

            $this->syncPlats($commande, $validated['plats']);
            $commande->calculerTotal();

            return redirect()
                ->route('commandes.show', $commande)
                ->with('success', 'Commande créée avec succès.');

    }

    public function show(Commande $commande)
    {
        $commande->load(['plats', 'serveur']);
        return view('commandes.show', compact('commande'));
    }

    public function edit(Commande $commande)
    {
        $commande->load('plats');
        $plats = Plat::all();
        $serveurs = \App\Models\User::where('role', 'serveur')->get();

        return view('commandes.edit', compact('commande', 'plats', 'serveurs'));
    }

    public function update(Request $request, Commande $commande)
    {
        $validated = $request->validate([
            'date_heure' => 'required|date',
            'serveur_id' => 'required|exists:users,id',
            'plats' => 'required|array|min:1',
            'plats.*.id' => 'required|exists:plats,id',
            'plats.*.quantite' => 'required|integer|min:1',
        ]);

            $commande->update([
                'date_heure' => $validated['date_heure'],
                'serveur_id' => $validated['serveur_id'],
            ]);

            $this->syncPlats($commande, $validated['plats']);
            $commande->calculerTotal();

            return redirect()
                ->route('commandes.show', $commande)
                ->with('success', 'Commande mise à jour.');
    }

    public function valider(Commande $commande)
    {
        $commande->statut = 'terminee';
        $commande->save();

        MouvementCaisse::create([
            'type' => 'entree',
            'montant' => $commande->total,
            'motif' => 'Paiement commande #' . $commande->id,
            'caissier_id' => Auth::check() ? Auth::id() : null,
        ]);

        return redirect()->route('commandes.index')->with('success', 'Commande validée avec succès. Mouvement de caisse enregistré.');
    }


    public function annuler(Commande $commande)
    {
        $commande->statut = 'annulee';
        $commande->save();

        return redirect()->route('commandes.index')->with('success', 'Commande annulée avec succès.');
    }

    public function calculerTotal(Commande $commande)
    {
        $total = $commande->plats()->withPivot('quantite')->get()->sum(function ($plat) {
            return $plat->pivot->quantite * $plat->prix_unitaire;
        });

        $commande->update(['total' => $total]);

        return response()->json([
            'message' => 'Total recalculé',
            'total' => number_format($total, 2, ',', ' ')
        ]);
    }

    protected function syncPlats(Commande $commande, array $plats): void
    {
        $platsData = collect($plats)->mapWithKeys(function ($item) {
            return [$item['id'] => ['quantite' => $item['quantite']]];
        })->toArray();

        $commande->plats()->sync($platsData);
    }
}