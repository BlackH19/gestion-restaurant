@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Ajouter un nouveau plat</h1>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('plats.store') }}" method="POST" id="plat-form">
                    @csrf

                    <div class="form-group">
                        <label for="nom_plat">Nom du plat</label>
                        <input type="text" name="nom_plat" id="nom_plat" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="quantite">Quantité disponible</label>
                        <input type="number" name="quantite" id="quantite" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="prix_unitaire">Prix unitaire (FCFA)</label>
                        <input type="number" step="0.01" name="prix_unitaire" id="prix_unitaire" class="form-control" required>
                    </div>

                    <!-- Section pour les ingrédients -->
                    <div class="form-group">
                        <label>Ingrédients</label>
                        <div id="ingredients-container">
                            <div class="ingredient-row mb-2 row">
                                <div class="col-md-5">
                                    <select name="ingredients[]" class="form-control ingredient-select" required>
                                        <option value="">Sélectionnez un ingrédient</option>
                                        @foreach($ingredients as $ingredient)
                                            <option value="{{ $ingredient->id }}" 
                                                    data-stock="{{ $ingredient->quantite }}"
                                                    data-unite="{{ $ingredient->unite }}">
                                                {{ $ingredient->nom }} (Stock: {{ $ingredient->quantite }} {{ $ingredient->unite }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input type="number" name="quantites[]" class="form-control ingredient-quantity" 
                                               placeholder="Quantité" step="0.01" min="0.01" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text unit-display">{{ $ingredients->first()->unite ?? '' }}</span>
                                        </div>
                                    </div>
                                    <small class="text-danger stock-error" style="display:none;">Quantité supérieure au stock</small>
                                </div>
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-danger remove-ingredient">Supprimer</button>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="add-ingredient" class="btn btn-secondary mt-2">+ Ajouter un ingrédient</button>
                    </div>

                    <!-- Optionnel : association à des commandes -->
                    @if($commandes->count() > 0)
                    <div class="form-group">
                        <label for="commandes">Associer à des commandes (optionnel)</label>
                        <select name="commandes[]" id="commandes" class="form-control" multiple>
                            @foreach($commandes as $commande)
                                <option value="{{ $commande->id }}">
                                    Commande #{{ $commande->id }} - {{ $commande->date_heure->format('d/m/Y H:i') }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Maintenez CTRL (ou CMD sur Mac) pour sélectionner plusieurs commandes.</small>
                    </div>
                    @endif

                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                    <a href="{{ route('plats.index') }}" class="btn btn-secondary">Annuler</a>
                </form>
            </div>
        </div>
    </div>

    <!-- Template pour les nouvelles lignes d'ingrédients (caché) -->
    <template id="ingredient-template">
        <div class="ingredient-row mb-2 row">
            <div class="col-md-5">
                <select name="ingredients[]" class="form-control ingredient-select" required>
                    <option value="">Sélectionnez un ingrédient</option>
                    @foreach($ingredients as $ingredient)
                        <option value="{{ $ingredient->id }}" 
                                data-stock="{{ $ingredient->quantite }}"
                                data-unite="{{ $ingredient->unite }}">
                            {{ $ingredient->nom }} (Stock: {{ $ingredient->quantite }} {{ $ingredient->unite }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <input type="number" name="quantites[]" class="form-control ingredient-quantity" 
                           placeholder="Quantité" step="0.01" min="0.01" required>
                    <div class="input-group-append">
                        <span class="input-group-text unit-display"></span>
                    </div>
                </div>
                <small class="text-danger stock-error" style="display:none;">Quantité supérieure au stock</small>
            </div>
            <div class="col-md-3">
                <button type="button" class="btn btn-danger remove-ingredient">Supprimer</button>
            </div>
        </div>
    </template>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Stocker les données des ingrédients pour validation
        const ingredientsData = @json($ingredients->keyBy('id')->map(function($i) { 
            return ['stock' => $i->quantite, 'unite' => $i->unite]; 
        }));

        // Ajouter un nouvel ingrédient
        document.getElementById('add-ingredient').addEventListener('click', function() {
            const template = document.getElementById('ingredient-template');
            const clone = template.content.cloneNode(true);
            document.getElementById('ingredients-container').appendChild(clone);
        });

        // Supprimer un ingrédient
        document.getElementById('ingredients-container').addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-ingredient')) {
                e.target.closest('.ingredient-row').remove();
                validateForm();
            }
        });

        // Gérer le changement d'ingrédient
        document.getElementById('ingredients-container').addEventListener('change', function(e) {
            if (e.target.classList.contains('ingredient-select')) {
                const row = e.target.closest('.ingredient-row');
                const selectedId = e.target.value;
                const unitDisplay = row.querySelector('.unit-display');
                const quantityInput = row.querySelector('.ingredient-quantity');
                const stockError = row.querySelector('.stock-error');

                if (selectedId && ingredientsData[selectedId]) {
                    // Mettre à jour l'unité de mesure
                    unitDisplay.textContent = ingredientsData[selectedId].unite;
                    
                    // Réinitialiser les erreurs
                    quantityInput.classList.remove('is-invalid');
                    stockError.style.display = 'none';
                    
                    // Définir le max pour la validation
                    quantityInput.max = ingredientsData[selectedId].stock;
                } else {
                    unitDisplay.textContent = '';
                }
                
                validateForm();
            }
        });

        // Valider la quantité lors de la saisie
        document.getElementById('ingredients-container').addEventListener('input', function(e) {
            if (e.target.classList.contains('ingredient-quantity')) {
                validateQuantity(e.target);
                validateForm();
            }
        });

        // Valider une quantité spécifique
        function validateQuantity(input) {
            const row = input.closest('.ingredient-row');
            const select = row.querySelector('.ingredient-select');
            const stockError = row.querySelector('.stock-error');
            
            if (!select.value) return true;
            
            const maxStock = ingredientsData[select.value].stock;
            const enteredQuantity = parseFloat(input.value) || 0;
            
            if (enteredQuantity > maxStock) {
                input.classList.add('is-invalid');
                stockError.style.display = 'block';
                return false;
            } else {
                input.classList.remove('is-invalid');
                stockError.style.display = 'none';
                return true;
            }
        }

        // Valider tout le formulaire
        function validateForm() {
            let isValid = true;
            const form = document.getElementById('plat-form');
            const submitBtn = form.querySelector('button[type="submit"]');
            
            // Vérifier les doublons
            const selectedIds = Array.from(document.querySelectorAll('.ingredient-select'))
                .map(select => select.value)
                .filter(value => value !== '');
            
            const duplicates = selectedIds.filter((item, index) => 
                selectedIds.indexOf(item) !== index
            );
            
            if (duplicates.length > 0) {
                isValid = false;
                alert('Un ingrédient ne peut être sélectionné qu\'une seule fois.');
            }
            
            // Vérifier les stocks
            document.querySelectorAll('.ingredient-quantity').forEach(input => {
                if (!validateQuantity(input)) {
                    isValid = false;
                }
            });
            
            // Activer/désactiver le bouton submit
            submitBtn.disabled = !isValid;
            
            return isValid;
        }

        // Validation avant soumission
        document.getElementById('plat-form').addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
                alert('Veuillez corriger les erreurs avant de soumettre le formulaire.');
            }
        });

        // Initialiser la validation
        validateForm();
    });
</script>
@endsection