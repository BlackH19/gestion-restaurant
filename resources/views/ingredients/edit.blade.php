@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Modifier l’ingrédient</h2>

    <form action="{{ route('ingredients.update', $ingredient) }}" method="POST">
        @csrf @method('PUT')

        @include('ingredients.form')

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('ingredients.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
