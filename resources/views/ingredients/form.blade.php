<div class="form-group">
    <label>Nom</label>
    <input type="text" name="nom" class="form-control" value="{{ old('nom', $ingredient->nom ?? '') }}" required>
</div>

<div class="form-group">
    <label>Quantité en stock</label>
    <input type="number" name="quantite_stock" step="0.01" class="form-control" value="{{ old('quantite_stock', $ingredient->quantite_stock ?? '') }}" required>
</div>

<div class="form-group">
    <label>Unité</label>
    <input type="text" name="unite" class="form-control" value="{{ old('unite', $ingredient->unite ?? '') }}" required>
</div>

<div class="form-group">
    <label>Prix unitaire (FCFA)</label>
    <input type="number" name="prix_unitaire" step="0.01" class="form-control" value="{{ old('prix_unitaire', $ingredient->prix_unitaire ?? '') }}" required>
</div>
