@extends('layouts.app')

@section('content')
<div class="container">
    <h1>État de la caisse</h1>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Total des entrées</div>
                <div class="card-body">
                    <h2 class="card-title">{{ number_format($totalEntrees, 0, ',', ' ') }}  FCFA</h2>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card text-white bg-danger mb-3">
                <div class="card-header">Total des sorties</div>
                <div class="card-body">
                    <h2 class="card-title">{{ number_format($totalSorties, 0, ',', ' ') }}  FCFA</h2>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header">
            <h3 class="mb-0">Solde actuel: {{ number_format($solde, 0, ',', ' ') }}  FCFA</h3>
        </div>
    </div>
    
    <div class="mt-3">
        <a href="{{ route('mouvements-caisse.index') }}" class="btn btn-primary">
            Retour à la liste
        </a>
    </div>
</div>
@endsection