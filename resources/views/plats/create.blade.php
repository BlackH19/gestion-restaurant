@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ajouter un nouveau plat</h1>
    
    <div class="card">
        <div class="card-body">
            <form action="{{ route('plats.store') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="nom_plat">Nom du plat</label>
                    <input type="text" name="nom_plat" id="nom_plat" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="prix_unitaire">Prix unitaire ( FCFA)</label>
                    <input type="number" step="0" name="prix_unitaire" id="prix_unitaire" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="quantite">Quantité disponible</label>
                    <input type="number" name="quantite" id="quantite" class="form-control" required>
                </div>

                {{-- Optionnel : tu peux permettre d'associer ce plat à plusieurs commandes --}}
                <div class="form-group">
                    <label for="commandes">Associer à des commandes (optionnel)</label>
                    <select name="commandes[]" id="commandes" class="form-control" multiple>
                        @foreach($commandes as $commande)
                        <option value="{{ $commande->id }}">
                            Commande #{{ $commande->id }} - {{ $commande->date_heure->format('d/m/Y H:i') }}

                        </option>
                        @endforeach
                    </select>
                    <small class="text-muted">Maintenez CTRL (ou CMD sur Mac) pour sélectionner plusieurs commandes.</small>
                </div>
                
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="{{ route('plats.index') }}" class="btn btn-secondary">Annuler</a>
            </form>
        </div>
    </div>
</div>
@endsection
