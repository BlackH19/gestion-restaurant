@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Gestion des Plats</h1>

    <div class="mb-4">
        <a href="{{ route('plats.create') }}" class="btn btn-primary">
            Ajouter un nouveau plat
        </a>
    </div>

    <div class="card">
        <div class="card-header">Liste des plats</div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prix unitaire</th>
                        <th>Quantité disponible</th>
                        <th>Commandes associées</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($plats as $plat)
                    <tr>
                        <td>{{ $plat->nom_plat }}</td>
                        <td>{{ number_format($plat->prix_unitaire, 0, ',', ' ') }}  FCFA</td>
                        <td>{{ $plat->quantite }}</td>
                        <td>
                            @if($plat->commandes && $plat->commandes->count())
                                @foreach($plat->commandes as $commande)
                                    <span class="badge bg-info text-white">Commande #{{ $commande->id }}</span>
                                @endforeach
                            @else
                                <span class="badge bg-secondary">Aucune</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('plats.show', $plat) }}" class="btn btn-sm btn-info">Voir</a>
                            <a href="{{ route('plats.edit', $plat) }}" class="btn btn-sm btn-warning">Modifier</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $plats->links() }}
        </div>
    </div>
</div>
@endsection
