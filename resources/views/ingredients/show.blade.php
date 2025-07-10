@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Détails de l’ingrédient</h2>

    <div class="card">
        <div class="card-body">
            <p><strong>Nom :</strong> {{ $ingredient->nom }}</p>
            <p><strong>Quantité stock :</strong> {{ $ingredient->quantite_stock }}</p>
            <p><strong>Unité :</strong> {{ $ingredient->unite }}</p>
            <p><strong>Prix unitaire :</strong> {{ $ingredient->prix_unitaire }} FCFA/{{ $ingredient->unite }}</p>
        </div>
    </div>

    <a href="{{ route('ingredients.edit', $ingredient) }}" class="btn btn-warning mt-3">Modifier</a>
    <a href="{{ route('ingredients.index') }}" class="btn btn-secondary mt-3">Retour</a>
</div>
@endsection
