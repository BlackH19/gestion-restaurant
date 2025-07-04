@extends('layouts.app')

@section('title', 'Détails de l’utilisateur')

@section('content')
<div class="container">
    <h1>Détails de l’utilisateur</h1>

    <ul class="list-group">
        <li class="list-group-item"><strong>Nom :</strong> {{ $user->name }}</li>
        <li class="list-group-item"><strong>Email :</strong> {{ $user->email }}</li>
        <li class="list-group-item"><strong>Rôle :</strong> {{ ucfirst($user->role) }}</li>
        <li class="list-group-item"><strong>Créé le :</strong> {{ $user->created_at->format('d/m/Y H:i') }}</li>
    </ul>

    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mt-3">Retour</a>
</div>
@endsection
