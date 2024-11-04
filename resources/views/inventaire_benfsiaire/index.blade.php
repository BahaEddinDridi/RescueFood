@extends('layouts.app')

@section('content')
<div class="container-fluid p-4 mb-5 wow fadeIn" data-wow-delay="0.1s" style="margin-top: 100px">
    <h1 class="text-center mb-4">Liste des Inventaires des Bénéficiaires</h1>

     <!-- Section de la localisation modifiable -->
     <div class="d-flex align-items-center justify-content-center mb-4">
        <h4 class="me-2">Localisation :</h4>
        <span id="localisation-text">{{ session('localisation') ?? $localisation ?? 'Non spécifiée' }}</span>
        <button class="btn btn-sm btn-outline-secondary ms-2" onclick="toggleEditForm()">
            <i class="fas fa-edit"></i> Modifier
        </button>
    </div>

    <form id="edit-localisation-form" action="{{ route('inventaires-beneficiaires.update-localisation') }}" method="POST" style="display: none;" class="d-flex align-items-center justify-content-center mb-4">
        @csrf
        <input type="text" name="localisation" class="form-control me-2" value="{{ $localisation ?? '' }}" placeholder="Nouvelle localisation" required>
        <button type="submit" class="btn btn-primary">Confirmer</button>
        <button type="button" class="btn btn-secondary ms-2" onclick="toggleEditForm()">Annuler</button>
    </form>


   

    <!-- Bouton pour ajouter un nouvel article -->
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('inventaires-beneficiaires.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Ajouter un nouvel article
        </a>
    </div>

    <!-- Section des produits disponibles -->
    <div class="mb-4">
        <h3 class="mb-3">Produits disponibles</h3>
        <div class="row">
            @foreach($produitsDisponibles as $produit)
                <div class="col-md-4 mb-3">
                    <div class="card shadow border-light">
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $produit->nom }}</h5>
                            <p class="card-text">Quantité disponible : <strong>{{ $produit->quantite }}</strong></p>
                            <i class="fas fa-box-open fa-3x text-primary mb-3"></i>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Section des produits dans l'inventaire des bénéficiaires -->
    <div class="mb-4">
        <h3 class="mb-3">Produits dans l'Inventaire des Bénéficiaires</h3>
        <div class="row">
            @foreach($inventaires as $inventaire)
                <div class="col-md-4 mb-3">
                    <div class="card shadow border-light">
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $inventaire->produit->nom }}</h5>
                            <p class="card-text">Quantité : <strong>{{ $inventaire->quantite }}</strong></p>
                          
                            <i class="fas fa-warehouse fa-3x text-success mb-3"></i>
                             <!-- Bouton de suppression -->
                             <form action="{{ route('inventaires-beneficiaires.destroy', $inventaire->id) }}" method="POST" class="mt-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm shadow-sm rounded-pill" onclick="return confirm('Voulez-vous vraiment supprimer ce produit de l\'inventaire?');">
                                    <i class="fas fa-trash-alt"></i> Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<style>
    .card {
    transition: transform 0.2s;
}

.card:hover {
    transform: scale(1.05);
}

.card-title {
    font-size: 1.25rem;
    font-weight: bold;
}

.card-text {
    font-size: 1rem;
}
</style>

<script>
    function toggleEditForm() {
        const form = document.getElementById('edit-localisation-form');
        const text = document.getElementById('localisation-text');

        // Log to the console to confirm the function is called
        console.log("Toggling edit form visibility.");

        // Toggle the visibility by adding/removing a class
        form.classList.toggle('d-none'); // Toggle visibility
        text.style.display = form.classList.contains('d-none') ? 'inline' : 'none'; // Show/hide text based on form visibility
    }
</script>
@endsection
