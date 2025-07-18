@extends('layouts.app')

@section('title', 'Créer un utilisateur')

@section('content')
    <div class="container">
        <h1>Créer un nouvel utilisateur</h1>

        <form action="{{ route('admin.users.store') }}" method="POST" id="userForm">
            @csrf

            <!-- Champs existants (nom, email) -->
            <div class="mb-3">
                <label for="name" class="form-label">Nom</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Adresse email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>

            <!-- Dans votre formulaire -->
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control" required>
                    <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                <div class="form-text">
                    <ul>
                        <li id="length" class="text-muted">Minimum 8 caractères</li>
                        <li id="uppercase" class="text-muted">Au moins une majuscule (A-Z)</li>
                        <li id="lowercase" class="text-muted">Au moins une minuscule (a-z)</li>
                        <li id="number" class="text-muted">Au moins un chiffre (0-9)</li>
                        <li id="special" class="text-muted">Au moins un caractère spécial (@$!%*?&)</li>
                    </ul>
                </div>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                <div class="input-group">
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                        required>
                    <button type="button" class="btn btn-outline-secondary" id="togglePasswordConfirmation">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            <!-- Rôle -->
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Éléments du DOM
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('password_confirmation');
            const form = document.getElementById('userForm');

            // 1. Fonction pour basculer l'affichage du mot de passe
            function setupPasswordToggle(fieldId, buttonId) {
                const field = document.getElementById(fieldId);
                const button = document.getElementById(buttonId);

                if (field && button) {
                    button.addEventListener('click', function () {
                        const type = field.getAttribute('type') === 'password' ? 'text' : 'password';
                        field.setAttribute('type', type);

                        // Change l'icône (Bootstrap Icons)
                        const icon = this.querySelector('i');
                        if (icon) {
                            icon.classList.toggle('bi-eye');
                            icon.classList.toggle('bi-eye-slash');
                        }
                    });
                }
            }

            // 2. Activation des boutons d'affichage
            setupPasswordToggle('password', 'togglePassword');
            setupPasswordToggle('password_confirmation', 'togglePasswordConfirmation');

            // 3. Validation en temps réel
            password.addEventListener('input', function () {
                const value = this.value;

                // Met à jour les indicateurs visuels
                document.getElementById('length').className = value.length >= 8 ? 'text-success' : 'text-muted';
                document.getElementById('uppercase').className = /[A-Z]/.test(value) ? 'text-success' : 'text-muted';
                document.getElementById('lowercase').className = /[a-z]/.test(value) ? 'text-success' : 'text-muted';
                document.getElementById('number').className = /\d/.test(value) ? 'text-success' : 'text-muted';
                document.getElementById('special').className = /[@$!%*?&]/.test(value) ? 'text-success' : 'text-muted';
            });

            // 4. Validation avant soumission
            form.addEventListener('submit', function (e) {
                const pwd = password.value;
                const confirmPwd = confirmPassword.value;

                // Vérification des critères
                const errors = [];

                if (pwd.length < 8) errors.push("- 8 caractères minimum");
                if (!/[A-Z]/.test(pwd)) errors.push("- Au moins une majuscule");
                if (!/[a-z]/.test(pwd)) errors.push("- Au moins une minuscule");
                if (!/\d/.test(pwd)) errors.push("- Au moins un chiffre");
                if (!/[@$!%*?&]/.test(pwd)) errors.push("- Au moins un caractère spécial (@$!%*?&)");
                if (pwd !== confirmPwd) errors.push("- Les mots de passe doivent correspondre");

                // Bloque la soumission si erreurs
                if (errors.length > 0) {
                    e.preventDefault();
                    alert("Erreurs de mot de passe :\n\n" + errors.join("\n"));
                    return false;
                }
            });
        });
    </script>

    <style>
        .text-success {
            color: #28a745 !important;
            font-weight: bold;
        }
    </style>
@endsection