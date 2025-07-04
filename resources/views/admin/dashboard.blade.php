@extends('layouts.app')

@section('title', 'Tableau de bord Administrateur')

@section('content')
<div class="container-fluid">
    <!-- En-tête -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tableau de bord Administrateur</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Générer rapport
        </a>
    </div>

    <!-- Cartes de statistiques -->
    <div class="row">
        <!-- Utilisateurs -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Utilisateurs</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['users'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Commandes (Mois) -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Commandes (30j)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['orders'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenus (Mois) -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Revenus (30j)</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ number_format($stats['revenue'], 2, ',', ' ') }} XOF</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Plats disponibles -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Plats disponibles</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['dishes'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-utensils fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="row">
        <!-- Graphique des commandes -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Historique des commandes (7 jours)</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="ordersChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activité récente -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Activité récente</h6>
                </div>
                <div class="card-body">
                    <div class="activity-feed">
                        @foreach($recentActivity as $activity)
                        <div class="feed-item mb-3">
                            <div class="feed-icon {{ $activity['color_class'] }}">
                                <i class="{{ $activity['icon'] }}"></i>
                            </div>
                            <div class="feed-content">
                                <strong>{{ $activity['user'] }}</strong> {{ $activity['action'] }}
                                <div class="text-muted small">{{ $activity['time'] }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableaux secondaires -->
    <div class="row">
        <!-- Dernières commandes -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Dernières commandes</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Table</th>
                                    <th>Serveur</th>
                                    <th>Montant</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                <tr>
                                    <td>#{{ $order->id }}</td>
                                    <td>{{ $order->table_numero }}</td>
                                    <td>{{ $order->serveur->name }}</td>
                                    <td>{{ number_format($order->total, 2, ',', ' ') }} XOF</td>
                                    <td>
                                        <span class="badge badge-{{ $order->status_badge }}">
                                            {{ ucfirst($order->statut) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Utilisateurs récents -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Derniers utilisateurs</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Rôle</th>
                                    <th>Inscrit le</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentUsers as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span class="badge badge-{{ $user->role_badge }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.activity-feed {
    padding-left: 10px;
}
.feed-item {
    position: relative;
    padding-bottom: 10px;
    padding-left: 30px;
    border-left: 2px solid #e4e8f0;
}
.feed-item:last-child {
    border-color: transparent;
}
.feed-icon {
    position: absolute;
    left: -15px;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    text-align: center;
    line-height: 30px;
    color: white;
}
.feed-content {
    padding-left: 15px;
}
</style>
@endpush

@push('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Graphique des commandes
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('ordersChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($ordersChart['labels']),
            datasets: [{
                label: 'Commandes',
                data: @json($ordersChart['data']),
                backgroundColor: 'rgba(78, 115, 223, 0.05)',
                borderColor: 'rgba(78, 115, 223, 1)',
                pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgba(78, 115, 223, 1)',
                pointRadius: 3,
                pointHoverRadius: 5,
                fill: true
            }]
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return Number.isInteger(value) ? value : '';
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return ' ' + context.parsed.y + ' commandes';
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush