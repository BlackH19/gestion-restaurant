@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier le plat: {{ $plat->nom_plat }}</h1>
    
    <div class="card">
        <div class="card-body">
            <form action="{{ route('plats.update', $plat) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="nom_plat">Nom du plat</label>
                    <input type="text" name="nom_plat" id="nom_plat" class="form-control" value="{{ $plat->nom_plat }}" required>
                </div>
                
                <div class="form-group">
                    <label for="prix_unitaire">Prix unitaire ( FCFA)</label>
                    <input type="number" step="0" name="prix_unitaire" id="prix_unitaire" 
                           class="form-control" value="{{ $plat->prix_unitaire }}" required>
                </div>
                
                <div class="form-group">
                    <label for="quantite">Quantité disponible</label>
                    <input type="number" name="quantite" id="quantite" 
                           class="form-control" value="{{ $plat->quantite }}" required>
                </div>
                
                <div class="form-group">
                    <label for="commande_id">Associer à une commande (optionnel)</label>
                    <select name="commande_id" id="commande_id" class="form-control">
                        <option value="">Aucune association</option>
                        @foreach($commandes as $commande)
                        <option value="{{ $commande->id }}" {{ $plat->commande_id == $commande->id ? 'selected' : '' }}>
                            Commande #{{ $commande->id }} - {{ $commande->date_heure->format('d/m/Y H:i') }}
                        </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    <a href="{{ route('plats.index') }}" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection