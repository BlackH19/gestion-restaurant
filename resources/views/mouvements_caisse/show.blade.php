@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Détails du mouvement</h1>
    
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Type:</strong> 
                        <span class="badge badge-{{ $mouvement->type === 'entree' ? 'success' : 'danger' }}">
                            {{ $mouvement->type === 'entree' ? 'Entrée' : 'Sortie' }}
                        </span>
                    </p>
                    <p><strong>Montant:</strong> {{ number_format($mouvement->montant, 0, ',', ' ') }}  FCFA</p>
                    <p><strong>Date:</strong> {{ $mouvement->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Motif:</strong> {{ $mouvement->motif ?? 'Non spécifié' }}</p>
                    <p><strong>Caissier:</strong> {{ $mouvement->caissier->name }}</p>
                </div>
            </div>
            
            <div class="mt-4">
                <a href="{{ route('mouvements-caisse.edit', $mouvement) }}" class="btn btn-warning">Modifier</a>
                <form action="{{ route('mouvements-caisse.destroy', $mouvement) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Confirmer la suppression ?')">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection