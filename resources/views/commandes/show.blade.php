@extends('layouts.app')

@section('title', 'Détails de la commande')

@section('content')
<div class="container mt-4">
    <h2>Détails de la commande #{{ $commande->id }}</h2>

    <p><strong>Date et heure :</strong> {{ $commande->date_heure }}</p>
    <p><strong>Serveur :</strong> {{ $commande->serveur->name }}</p>
    <p><strong>Statut :</strong> {{ ucfirst($commande->statut) }}</p>
    <p><strong>Total :</strong> {{ number_format($commande->total, 2, ',', ' ') }} FCFA</p>

    <h4>Plats commandés</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prix unitaire</th>
                <th>Quantité</th>
                <th>Sous-total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($commande->plats as $plat)
                <tr>
                    <td>{{ $plat->nom_plat }}</td>
                    <td>{{ number_format($plat->prix_unitaire, 2, ',', ' ') }} FCFA</td>
                    <td>{{ $plat->pivot->quantite }}</td>
                    <td>{{ number_format($plat->prix_unitaire * $plat->pivot->quantite, 2, ',', ' ') }} FCFA</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('commandes.edit', $commande) }}" class="btn btn-warning">Modifier</a>
    <a href="{{ route('commandes.index') }}" class="btn btn-secondary">Retour</a>
</div>
@endsection
