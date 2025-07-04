@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Gestion des commandes</h1>

        <div class="mb-3">
            <a href="{{ route('commandes.create') }}" class="btn btn-primary">
                Nouvelle commande
            </a>
        </div>

        <div class="card">
            <div class="card-header">Liste des commandes</div>
            <div class="card-body">
                @if ($commandes->count() > 0)
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Date/Heure</th>
                                <th>Serveur</th>
                                <th>Total (FCFA)</th>
                                <th>Actions</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($commandes as $commande)
                                <tr>
                                    <td>{{ $commande->id }}</td>
                                    <td>{{ \Carbon\Carbon::parse($commande->date_heure)->format('d/m/Y H:i') }}</td>
                                    <td>{{ $commande->serveur->name ?? 'N/A' }}</td>
                                    <td>{{ number_format($commande->total, 0, ',', ' ') }}</td>
                                    <td>
                                        <a href="{{ route('commandes.show', $commande) }}" class="btn btn-sm btn-info">Voir</a>
                                        @if(ucfirst($commande->statut ?? '') == 'En_attente')
                                            <a href="{{ route('commandes.edit', $commande) }}"
                                                class="btn btn-sm btn-warning">Modifier</a>
                                            <form action="{{ route('commandes.valider', $commande) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success">Valider</button>
                                            </form>
                                            <form action="{{ route('commandes.annuler', $commande) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Annuler cette commande ?')">Annuler</button>
                                            </form>
                                        @endif
                                    </td>
                                    <td>
                                        @if  (ucfirst(string: $commande->statut ?? '') == 'En_attente')
                                            <span class="badge bg-warning">En cours</span>
                                        @elseif(ucfirst(string: $commande->statut ?? '') == 'Terminee')
                                            <span class="badge bg-success">Terminée</span>
                                        @elseif(ucfirst(string: $commande->statut ?? '') == 'Annulee')
                                            <span class="badge bg-danger">Annulée</span>
                                        @else
                                            <span class="badge bg-secondary">Statut inconnu</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Pagination --}}
                    <div class="mt-3">
                        {{ $commandes->links() }}
                    </div>

                @else
                    <p>Aucune commande enregistrée pour le moment.</p>
                @endif
            </div>
        </div>
    </div>
@endsection