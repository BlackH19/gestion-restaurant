@extends('layouts.app')

@section('title', 'Tableau de bord Caissier')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="h3 mb-0 text-gray-800">Tableau de bord - Caisse</h1>
        </div>
    </div>

    <!-- Cartes de statistiques -->
    <div class="row">
        <!-- Solde actuel -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Solde actuel</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($solde, 2, ',', ' ') }} €
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-wallet fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Entrées aujourd'hui -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Entrées (Aujourd'hui)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($entreesAujourdhui, 2, ',', ' ') }} XOF
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-arrow-down fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sorties aujourd'hui -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Sorties (Aujourd'hui)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($sortiesAujourdhui, 2, ',', ' ') }} €
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-arrow-up fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Opérations de caisse -->
    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Nouvelle opération</h6>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="operationTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="entree-tab" data-toggle="tab" href="#entree" role="tab">
                                <i class="fas fa-arrow-down mr-1"></i> Entrée
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="sortie-tab" data-toggle="tab" href="#sortie" role="tab">
                                <i class="fas fa-arrow-up mr-1"></i> Sortie
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content mt-3" id="operationTabContent">
                        <!-- Formulaire Entrée -->
                        <div class="tab-pane fade show active" id="entree" role="tabpanel">
                            <form action="{{ route('caisse.entree') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="montantEntree">Montant</label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" class="form-control" id="montantEntree" 
                                               name="montant" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">€</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="motifEntree">Motif</label>
                                    <input type="text" class="form-control" id="motifEntree" name="motif" required>
                                </div>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-check mr-1"></i> Enregistrer l'entrée
                                </button>
                            </form>
                        </div>

                        <!-- Formulaire Sortie -->
                        <div class="tab-pane fade" id="sortie" role="tabpanel">
                            <form action="{{ route('caisse.sortie') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="montantSortie">Montant</label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" class="form-control" id="montantSortie" 
                                               name="montant" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">€</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="motifSortie">Motif</label>
                                    <input type="text" class="form-control" id="motifSortie" name="motif" required>
                                </div>
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-check mr-1"></i> Enregistrer la sortie
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dernières opérations -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Dernières opérations</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Montant</th>
                                    <th>Motif</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($mouvements as $mouvement)
                                <tr>
                                    <td>{{ $mouvement->created_at->format('H:i') }}</td>
                                    <td>
                                        <span class="badge badge-{{ $mouvement->type === 'entree' ? 'success' : 'danger' }}">
                                            {{ ucfirst($mouvement->type) }}
                                        </span>
                                    </td>
                                    <td class="text-{{ $mouvement->type === 'entree' ? 'success' : 'danger' }}">
                                        {{ number_format($mouvement->montant, 2, ',', ' ') }} €
                                    </td>
                                    <td>{{ $mouvement->motif }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Aucune opération enregistrée</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Initialisation des tooltips
$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
@endpush