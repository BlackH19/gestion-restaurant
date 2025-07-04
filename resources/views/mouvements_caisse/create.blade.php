@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Nouveau mouvement de caisse</h1>
    
    <div class="card">
        <div class="card-body">
            <form action="{{ route('mouvements-caisse.store') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="type">Type de mouvement</label>
                    <select name="type" id="type" class="form-control" required>
                        <option value="">Sélectionnez...</option>
                        <option value="entree">Entrée</option>
                        <option value="sortie">Sortie</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="montant">Montant</label>
                    <input type="number" step="0.01" name="montant" id="montant" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="motif">Motif</label>
                    <textarea name="motif" id="motif" class="form-control" rows="3"></textarea>
                </div>
                
                <input type="hidden" name="caissier_id" value="{{ auth()->id() }}">
                
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </form>
        </div>
    </div>
</div>
@endsection