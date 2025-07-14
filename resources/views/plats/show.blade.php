@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Détails du plat</h1>
    
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Nom:</strong> {{ $plat->nom_plat }}</p>
                    <p><strong>Prix unitaire:</strong> {{ number_format($plat->prix_unitaire, 0,   ',', ' ') }}  FCFA</p>
                </div>
                <!-- <div class="col-md-6">
                    <p><strong>Quantité disponible:</strong> {{ $plat->quantite }}</p>
                    <p><strong>Statut:</strong> 
                        @if($plat->quantite > 0)
                            <span class="badge badge-success">Disponible</span>
                        @else
                            <span class="badge badge-danger">Épuisé</span>
                        @endif
                    </p>
                </div> -->
            </div>
            
            @if($plat->commande)
            <div class="mt-4">
                <h4>Commande associée</h4>
                <p><strong>Commande #{{ $plat->commande->id }}</strong> du {{ $plat->commande->date_heure->format('d/m/Y') }}</p>
            </div>
            @endif
            
            <div class="mt-4">
                <a href="{{ route('plats.edit', $plat) }}" class="btn btn-warning">Modifier</a>
                <form action="{{ route('plats.destroy', $plat) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Confirmer la suppression ?')">Supprimer</button>
                </form>
                <a href="{{ route('plats.index') }}" class="btn btn-secondary">Retour</a>
            </div>
        </div>
    </div>
</div>
@endsection