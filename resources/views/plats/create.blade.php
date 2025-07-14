@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Ajouter un nouveau plat</h1>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('plats.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="nom_plat">Nom du plat</label>
                        <input type="text" name="nom_plat" id="nom_plat" class="form-control" required>
                    </div>

                    <!-- <div class="form-group">
                        <label for="quantite">Quantité disponible</label>
                        <input type="number" name="quantite" id="quantite" class="form-control" required>
                    </div> -->

                    <div class="form-group">
                        <label for="prix_unitaire">Prix unitaire (FCFA)</label>
                        <input type="number" step="0" name="prix_unitaire" id="prix_unitaire" class="form-control" required>
                    </div>

                    <!-- Section pour les ingrédients -->
                    <div class="form-group">
                        <label>Ingrédients</label>
                        <div id="ingredients-container">
                            <div class="ingredient-row mb-2 row">
                                <div class="col-md-5">
                                    <select name="ingredients[0][id]" class="form-control" required>
                                        <option value="">Sélectionner un ingrédient</option>
                                        @foreach($ingredients as $ingredient)
                                            <option value="{{ $ingredient->id }}">{{ $ingredient->nom }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="number" name="ingredients[0][quantite]" class="form-control"
                                        placeholder="Quantité" required>
                                </div>
                                <div class="col-md-3">
                                    <select name="ingredients[0][unite]" class="form-control" aria-placeholder="Unité" required>
                                        <option value="">Sélectionner une unité</option>
                                        @foreach(['g', 'kg', 'ml', 'L', 'unité', 'c.à.c', 'c.à.s', 'pincée', 'tasse'] as $unite)
                                            <option value="{{ $unite }}" {{ old('ingredients.0.unite') == $unite ? 'selected' : '' }}>
                                                @switch($unite)
                                                    @case('g') Grammes (g) @break
                                                    @case('kg') Kilogrammes (kg) @break
                                                    @case('ml') Millilitres (ml) @break
                                                    @case('L') Litres (L) @break
                                                    @case('unité') Unité @break
                                                    @case('c.à.c') Cuillère à café @break
                                                    @case('c.à.s') Cuillère à soupe @break
                                                    @case('pincée') Pincée @break
                                                    @case('tasse') Tasse @break
                                                    @default {{ $unite }}
                                                @endswitch
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="add-ingredient" class="btn btn-sm btn-secondary mt-2">
                            <i class="fas fa-plus"></i> Ajouter un ingrédient
                        </button>
                    </div>

                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                    <a href="{{ route('plats.index') }}" class="btn btn-secondary">Annuler</a>
                </form>
            </div>
        </div>
    </div>

    <script>
       document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('ingredients-container');
            const addButton = document.getElementById('add-ingredient');
            let counter = 1;

            addButton.addEventListener('click', function() {
                const newRow = document.createElement('div');
                newRow.className = 'ingredient-row mb-3 row';
                newRow.innerHTML = `
                    <div class="col-md-5 form-group">
                        <select name="ingredients[${counter}][id]" class="form-control" required>
                            <option value="">Sélectionner un ingrédient</option>
                            @foreach($ingredients as $ingredient)
                                <option value="{{ $ingredient->id }}">{{ $ingredient->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        <input type="number" name="ingredients[${counter}][quantite]" class="form-control" placeholder="Quantité" required>
                    </div>
                    <div class="col-md-3 form-group">
                        <select name="ingredients[${counter}][unite]" class="form-control" aria-placeholder="Unité" required>
                            <option value="">Sélectionner une unité</option>
                            @foreach(['g', 'kg', 'ml', 'L', 'unité', 'c.à.c', 'c.à.s', 'pincée', 'tasse'] as $unite)
                                <option value="{{ $unite }}">
                                    @switch($unite)
                                        @case('g') Grammes (g) @break
                                        @case('kg') Kilogrammes (kg) @break
                                        @case('ml') Millilitres (ml) @break
                                        @case('L') Litres (L) @break
                                        @case('unité') Unité @break
                                        @case('c.à.c') Cuillère à café @break
                                        @case('c.à.s') Cuillère à soupe @break
                                        @case('pincée') Pincée @break
                                        @case('tasse') Tasse @break
                                        @default {{ $unite }}
                                    @endswitch
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger btn-sm remove-ingredient">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                `;
                
                container.appendChild(newRow);
                counter++;
            });

            // Gestion de la suppression
            container.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-ingredient') || e.target.closest('.remove-ingredient')) {
                    e.target.closest('.ingredient-row').remove();
                }
            });
        });
    </script>

    <style>
        .ingredient-row {
            align-items: center;
        }

        .remove-ingredient {
            padding: 0.25rem 0.5rem;
        }
    </style>
@endsection