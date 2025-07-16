@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Gestion des Plats</h1>
        @if (auth()->user()->isAdmin())
            <div class="mb-4">
                <a href="{{ route('plats.create') }}" class="btn btn-primary">
                    Ajouter un nouveau plat
                </a>
            </div>
        @endif


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
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($plats as $plat)
                            <tr>
                                <td>{{ $plat->nom_plat }}</td>
                                <td>{{ number_format($plat->prix_unitaire, 0, ',', ' ') }} FCFA</td>
                                <td>{{ $plat->quantite }}</td>
                                <td>
                                    @if($plat->commandes->count() > 0)
                                        <span class="badge bg-info text-white">
                                            {{ $plat->commandes->count() }} commande(s)
                                        </span>
                                        <small class="text-muted">
                                            Dernière: #{{ $plat->commandes->last()->id }}
                                        </small>
                                    @else
                                        <span class="badge bg-secondary">Aucune</span>
                                    @endif
                                </td>
                                <td>
                                    @if($plat->quantite > 0)
                                        <span class="badge bg-success">Disponible</span>
                                    @else
                                        <span class="badge bg-danger">Indisponible</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('plats.show', $plat) }}" class="btn btn-sm btn-info">Voir</a>
                                    @if (auth()->user()->isAdmin())
                                        <a href="{{ route('plats.edit', $plat) }}" class="btn btn-sm btn-warning">Modifier</a>
                                        <form action="{{ route('plats.destroy', $plat) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                                        </form>
                                    @endif
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