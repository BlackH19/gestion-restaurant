@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Liste des Ingrédients</h2>

    <a href="{{ route('ingredients.create') }}" class="btn btn-success mb-3">+ Ajouter un ingrédient</a>

    <!-- @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif -->

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Quantité stock</th>
                <th>Unité</th>
                <th>Prix unitaire</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ingredients as $ingredient)
            <tr>
                <td>{{ $ingredient->nom }}</td>
                <td>{{ $ingredient->quantite_stock }}</td>
                <td>{{ $ingredient->unite }}</td>
                <td>{{ $ingredient->prix_unitaire }} FCFA/{{ $ingredient->unite }}</td>
                <td>
                    <a href="{{ route('ingredients.show', $ingredient) }}" class="btn btn-info btn-sm">Voir</a>
                    <a href="{{ route('ingredients.edit', $ingredient) }}" class="btn btn-warning btn-sm">Modifier</a>
                    <form action="{{ route('ingredients.destroy', $ingredient) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ?')">Supprimer</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5">Aucun ingrédient trouvé.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
