@extends('layouts.app')

@section('title', 'Créer un utilisateur')

@section('content')
    <div class="container">
        <h1>Créer un nouvel utilisateur</h1>

        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Nom</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Adresse email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Rôle</label>
                <select name="role" id="role" class="form-control" required>
                    <option value="admin">Admin</option>
                    <option value="serveur">Serveur</option>
                    <option value="caissier">Caissier</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Créer</button>
            <a href="{{ route('admin.users') }}" class="btn btn-secondary">Retour</a>
        </form>
    </div>
    </form>
    </div>
@endsection