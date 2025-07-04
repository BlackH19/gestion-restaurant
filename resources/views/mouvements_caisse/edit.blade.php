@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier le mouvement</h1>
    
    <div class="card">
        <div class="card-body">
            <form action="{{ route('mouvements-caisse.update', $mouvement) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="type">Type de mouvement</label>
                    <select name="type" id="type" class="form-control" required>
                        <option value="entree" {{ $mouvement->type === 'entree' ? 'selected' : '' }}>Entrée</option>
                        <option value="sortie" {{ $mouvement->type === 'sortie' ? 'selected' : '' }}>Sortie</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="montant">Montant</label>
                    <input type="number" step="0.01" name="montant" id="montant" 
                           class="form-control" value="{{ $mouvement->montant }}" required>
                </div>
                
                <div class="form-group">
                    <label for="motif">Motif</label>
                    <textarea name="motif" id="motif" class="form-control" rows="3">{{ $mouvement->motif }}</textarea>
                </div>
                
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                <a href="{{ route('mouvements-caisse.index') }}" class="btn btn-secondary">Annuler</a>
            </form>
        </div>
    </div>
</div>
@endsection