<div class="form-group">
    <label>Nom</label>
    <input type="text" name="nom" class="form-control" value="{{ old('nom', $ingredient->nom ?? '') }}" required>
</div>

<div class="form-group">
    <label>Quantité en stock</label>
    <input type="number" name="quantite_stock" step="0.01" class="form-control" value="{{ old('quantite_stock', $ingredient->quantite_stock ?? '') }}" required>
</div>

<div class="form-group">
    <label for="unite">Unité</label>
    <select name="unite" id="unite" class="form-control" required>
        <option value="">Sélectionner une unité</option>
        @foreach(['g', 'kg', 'ml', 'L', 'unité', 'c.à.c', 'c.à.s', 'pincée', 'tasse'] as $unite)
            <option value="{{ $unite }}" {{ old('unite', $ingredient->unite ?? '') == $unite ? 'selected' : '' }}>
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

<div class="form-group">
    <label>Prix unitaire (FCFA)</label>
    <input type="number" name="prix_unitaire" step="0.01" class="form-control" value="{{ old('prix_unitaire', $ingredient->prix_unitaire ?? '') }}" required>
</div>
