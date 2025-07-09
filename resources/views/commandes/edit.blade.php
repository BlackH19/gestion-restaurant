@extends('layouts.app')

@section('title', 'Modifier la commande')

@section('content')
<div class="container mt-4">
    <h2>Modifier la commande #{{ $commande->id }}</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('commandes.update', $commande) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="date_heure" class="form-label">Date et heure</label>
            <input type="datetime-local" name="date_heure" id="date_heure"
                value="{{ $commande->date_heure->format('Y-m-d\TH:i') }}" class="form-control" required>
        </div>

        <hr>
        <h4>Plats</h4>
        <div id="plats-wrapper">
            @foreach($commande->plats as $index => $plat)
                <div class="row mb-3 plat-item">
                    <div class="col-md-6">
                        <label>Plat</label>
                        <select name="plats[{{ $index }}][id]" class="form-control" required>
                            <option value="">-- Choisir un plat --</option>
                            @foreach($plats as $p)
                                <option value="{{ $p->id }}"
                                    @selected($p->id === $plat->id)>
                                    {{ $p->nom_plat }} - {{ number_format($p->prix_unitaire, 0, ',', ' ') }} FCFA
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Quantité</label>
                        <input type="number" name="plats[{{ $index }}][quantite]" value="{{ $plat->pivot->quantite }}"
                            class="form-control" required>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger remove-plat">Supprimer</button>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mb-3">
            <button type="button" id="add-plat" class="btn btn-secondary">Ajouter un plat</button>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
@verbatim
<script>
    //let platIndex = count($commande->plats) ;

    document.getElementById('add-plat').addEventListener('click', function () {
        const wrapper = document.getElementById('plats-wrapper');
        const newRow = document.createElement('div');
        newRow.className = 'row mb-3 plat-item';
        newRow.innerHTML = `
            <div class="col-md-6">
                <label>Plat</label>
                <select name="plats[${platIndex}][id]" class="form-control" required>
                    <option value="">-- Choisir un plat --</option>
                    @foreach($plats as $p)
                        <option value="{{ $p->id }}">{{ $p->nom_plat }} - {{ number_format($p->prix_unitaire, 0, ',', ' ') }} FCFA</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label>Quantité</label>
                <input type="number" name="plats[${platIndex}][quantite]" class="form-control" min="1" required>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-danger remove-plat">Supprimer</button>
            </div>
        `;
        wrapper.appendChild(newRow);
        platIndex++;
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-plat')) {
            e.target.closest('.plat-item').remove();
        }
    });
</script>
@endverbatim
@endsection