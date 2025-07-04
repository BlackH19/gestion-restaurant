<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller; 
use App\Models\User;
use App\Models\Plat;
use App\Models\Commande;
use App\Models\MouvementCaisse;
use Illuminate\Support\Facades\DB;
use App\Http\Middleware\CheckRole;
use Faker\Provider\Base;

class AdminController extends Controller
{
   

    public function dashboard()
    {
        // Statistiques principales
        $stats = [
            'users' => User::count(),
            'orders' => Commande::where('created_at', '>=', now()->subDays(30))->count(),
            'revenue' => MouvementCaisse::where('type', 'entree')
                            ->where('created_at', '>=', now()->subDays(30))
                            ->sum('montant'),
            'dishes' => Plat::where('disponible', true)->count()
        ];

        // Données pour le graphique des commandes (7 derniers jours)
        $ordersChart = $this->getOrdersChartData();

        // Activité récente
        $recentActivity = $this->getRecentActivity();

        // Dernières commandes
        $recentOrders = Commande::with('serveur')
                            ->latest()
                            ->take(5)
                            ->get()
                            ->map(function($order) {
                                $order->status_badge = $this->getStatusBadge($order->statut);
                                return $order;
                            });

        // Derniers utilisateurs
        $recentUsers = User::with('roles')
                        ->latest()
                        ->take(5)
                        ->get()
                        ->map(function($user) {
                            $user->role = $user->getRoleNames()->first() ?? 'N/A';
                            $user->role_badge = $this->getRoleBadge($user->role);
                            return $user;
                        });

        return view('admin.dashboard', compact(
            'stats',
            'ordersChart',
            'recentActivity',
            'recentOrders',
            'recentUsers'
        ));
    }

    private function getOrdersChartData()
    {
        $dates = collect();
        $data = collect();

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dates->push(now()->subDays($i)->format('D d/m'));
            
            $count = Commande::whereDate('created_at', $date)->count();
            $data->push($count);
        }

        return [
            'labels' => $dates,
            'data' => $data
        ];
    }

    private function getRecentActivity()
    {
        // Exemple d'activité - À adapter avec votre système d'activité
        return [
            [
                'user' => 'Admin',
                'action' => 'a créé un nouveau plat',
                'icon' => 'fas fa-utensils',
                'color_class' => 'bg-primary',
                'time' => 'Il y a 5 min'
            ],
            [
                'user' => 'Serveur 1',
                'action' => 'a pris une nouvelle commande',
                'icon' => 'fas fa-clipboard-list',
                'color_class' => 'bg-success',
                'time' => 'Il y a 15 min'
            ],
            [
                'user' => 'Caissier 1',
                'action' => 'a enregistré un paiement',
                'icon' => 'fas fa-cash-register',
                'color_class' => 'bg-info',
                'time' => 'Il y a 30 min'
            ]
        ];
    }

    private function getStatusBadge($status)
    {
        switch ($status) {
            case 'payée': return 'success';
            case 'servie': return 'info';
            case 'annulée': return 'danger';
            default: return 'warning';
        }
    }

    private function getRoleBadge($role)
    {
        switch ($role) {
            case 'admin': return 'primary';
            case 'caissier': return 'success';
            case 'serveur': return 'info';
            default: return 'secondary';
        }
    }
}