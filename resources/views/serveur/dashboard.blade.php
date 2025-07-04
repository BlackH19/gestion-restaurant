@extends('layouts.app')

@section('title', 'Tableau de bord Serveur')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="h3 mb-0 text-gray-800">Tableau de bord - Service</h1>
        </div>
    </div>

    <!-- Commandes en cours -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Nouvelle commande</h6>
                </div>
                <div class="card-body">
                    <form id="commandeForm" action="{{ route('serveur.commande.create') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="table_numero">Numéro de table</label>
                            <input type="number" class="form-control" id="table_numero" name="table_numero" required min="1">
                        </div>

                        <div id="platsContainer" class="mb-3">
                            <!-- Les plats seront ajoutés ici -->
                        </div>

                        <button type="button" id="ajouterPlat" class="btn btn-secondary btn-sm mb-3">
                            <i class="fas fa-plus mr-1"></i> Ajouter un plat
                        </button>

                        <div class="form-group">
                            <label for="notes">Notes supplémentaires</label>
                            <textarea class="form-control" id="notes" name="notes" rows="2"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary mt-2">
                            <i class="fas fa-check mr-1"></i> Valider la commande
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Commandes récentes -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Vos commandes récentes</h6>
                </div>
                <div class="card-body">
                    @forelse($commandes as $commande)
                    <div class="mb-3 p-2 border-bottom">
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-bold">Table #{{ $commande->table_numero }}</h6>
                            <span class="badge badge-{{ $commande->statut === 'servie' ? 'success' : 'warning' }}">
                                {{ ucfirst($commande->statut) }}
                            </span>
                        </div>
                        <small class="text-muted">
                            {{ $commande->created_at->format('H:i') }} - #{{ $commande->id }}
                        </small>
                        
                        <ul class="mt-2 pl-3">
                            @foreach($commande->plats as $plat)
                            <li>
                                {{ $plat->nom }} 
                                <span class="text-muted">(x{{ $plat->pivot->quantite }})</span>
                            </li>
                            @endforeach
                        </ul>

                        @if($commande->statut !== 'servie')
                        <form action="{{ route('serveur.commande.servie', $commande->id) }}" method="POST" class="mt-2">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">
                                <i class="fas fa-check mr-1"></i> Marquer comme servie
                            </button>
                        </form>
                        @endif
                    </div>
                    @empty
                    <div class="text-center text-muted">
                        Aucune commande récente
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Données des plats disponibles
const platsDisponibles = @json($plats);

document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('platsContainer');
    let platCount = 0;

    // Fonction pour ajouter un plat au formulaire
    function ajouterPlat(platId = '', quantite = 1) {
        const platSelectId = `plats[${platCount}][plat_id]`;
        const quantiteId = `plats[${platCount}][quantite]`;
        
        const div = document.createElement('div');
        div.className = 'row mb-2 align-items-center plat-item';
        div.innerHTML = `
            <div class="col-md-6">
                <select name="${platSelectId}" class="form-control" required>
                    <option value="">Sélectionner un plat</option>
                    ${platsDisponibles.map(plat => `
                        <option value="${plat.id}" ${plat.id == platId ? 'selected' : ''}>
                            ${plat.nom} - ${plat.prix.toFixed(2)} €
                        </option>
                    `).join('')}
                </select>
            </div>
            <div class="col-md-4">
                <input type="number" name="${quantiteId}" value="${quantite}" 
                       min="1" class="form-control" required>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-sm remove-plat">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        
        container.appendChild(div);
        platCount++;
    }

    // Ajouter le premier plat par défaut
    ajouterPlat();

    // Gestion du bouton "Ajouter un plat"
    document.getElementById('ajouterPlat').addEventListener('click', function() {
        ajouterPlat();
    });

    // Gestion de la suppression d'un plat
    container.addEventListener('click', function(e) {
        if (e.target.closest('.remove-plat')) {
            e.target.closest('.plat-item').remove();
        }
    });

    // Validation du formulaire
    document.getElementById('commandeForm').addEventListener('submit', function(e) {
        // Validation supplémentaire si nécessaire
    });
});
</script>
@endpush