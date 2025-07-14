@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Gestion des mouvements de caisse</h1>
    
    <div class="mb-4">
        <a href="{{ route('mouvements-caisse.create') }}" class="btn btn-primary">
            Nouveau mouvement
        </a>
        <a href="{{ route('caisse.solde') }}" class="btn btn-info ml-2">
            Voir le solde
        </a>
    </div>

    <div class="card">
        <div class="card-header">Liste des mouvements</div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Montant</th>
                        <th>Motif</th>
                        <th>Caissier</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mouvements as $mouvement)
                    <tr>
                        <td>{{ $mouvement->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <span class="badge badge-{{ $mouvement->type === 'entree' ? 'success' : 'danger' }}">
                                {{ $mouvement->type === 'entree' ? 'Entrée' : 'Sortie' }}
                            </span>
                        </td>
                        <td>{{ number_format($mouvement->montant, 0, ',', ' ') }}  FCFA</td>
                        <td>{{ $mouvement->motif ?? '-' }}</td>
                        <td>{{ $mouvement->caissier->name }}</td>
                        <td>
                            <a href="{{ route('mouvements-caisse.show', $mouvement) }}" class="btn btn-sm btn-info">Voir</a>
                            <!-- <a href="{{ route('mouvements-caisse.edit', $mouvement) }}" class="btn btn-sm btn-warning">Modifier</a> -->
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            {{ $mouvements->links() }}
        </div>
    </div>
</div>
@endsection