@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Ajouter un ingrédient</h2>

    <form action="{{ route('ingredients.store') }}" method="POST">
        @csrf

        @include('ingredients.form')

        <button type="submit" class="btn btn-primary">Enregistrer</button>
        <a href="{{ route('ingredients.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
