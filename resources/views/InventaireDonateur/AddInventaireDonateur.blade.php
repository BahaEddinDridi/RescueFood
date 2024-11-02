@extends('layouts.app')

@section('content')

<div class="container-fluid p-4 mb-5 wow fadeIn" data-wow-delay="0.1s" style="margin-top: 100px;">
    <h1 class="text-center mb-5" style="color: #4A4A4A;">Inventaire des Produits Alimentaires</h1>
    
    @if($produitsAlimentaires->isEmpty())
        <div class="alert alert-warning text-center">
            <strong>Aucun produit alimentaire trouvé.</strong>
        </div>
    @else
        <form action="{{ route('invertaireDonateurs.addSelectedProduits') }}" method="POST">
            @csrf
            <input type="hidden" name="userId" value="{{ $userId }}">
            
            <!-- Barre de Recherche -->
            <div class="input-group mb-4 w-75 mx-auto">
                <input type="text" id="searchInput" class="form-control form-control-lg" placeholder="Rechercher un produit..." aria-label="Search Products" style="height: 50px;">
                <div class="input-group-append">
                    <button class="btn btn-primary text-white d-flex align-items-center justify-content-center" style="height: 50px; padding: 0 20px; font-size: 1.5em;">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>

            <div class="row">
                @foreach ($produitsAlimentaires as $produit)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-primary" style="border-radius: 10px;">
                        <div class="card-body text-center">
                            <h5 class="card-title text-primary mb-4" style="font-weight: bold; font-size: 1.75rem;">{{ $produit->nom }}</h5>
                            <p class="card-text" style="color: #555;">
                                <i class="fas fa-tag"></i> <strong>Catégorie:</strong> {{ $produit->categorie }}
                            </p>
                            <p class="card-text" style="color: #28a745;">
                                <i class="fas fa-box"></i> <strong>Quantité disponible:</strong> {{ $produit->quantite }}
                            </p>
                            <p class="card-text" style="color: #dc3545;">
                                <i class="fas fa-calendar-alt"></i> <strong>Date de péremption:</strong> {{ \Carbon\Carbon::parse($produit->date_peremption)->format('d/m/Y') }}
                            </p>
                            <p class="card-text" style="color: #17a2b8;">
                                <i class="fas fa-info-circle"></i> <strong>Type:</strong> {{ $produit->type }}
                            </p>
                            <input class="form-check-input" type="checkbox" name="produits[]" value="{{ $produit->id }}" id="produit_{{ $produit->id }}">
                            <label class="form-check-label" for="produit_{{ $produit->id }}">
                              Sélectionner
                            </label>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary" style="padding: 10px 30px; font-size: 1.25rem;">Ajouter des Produits Sélectionnés</button>
            </div>
        </form>

        <!-- Liens de pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $produitsAlimentaires->links('pagination::bootstrap-4') }} 
        </div>
    @endif
</div>

<script>
document.getElementById('searchInput').addEventListener('keyup', function() {
    const filter = this.value.toLowerCase();
    const items = document.querySelectorAll('.card');

    items.forEach(item => {
        const title = item.querySelector('.card-title').textContent.toLowerCase();
        const category = item.querySelector('.card-text').textContent.toLowerCase();
        
        if (title.includes(filter) || category.includes(filter)) {
            item.parentElement.style.display = ''; // Show card
        } else {
            item.parentElement.style.display = 'none'; // Hide card
        }
    });
});
</script>

<style>
    .pagination {
        justify-content: center; 
    }
    .pagination .page-link {
        padding: 0.5rem 0.75rem; 
        font-size: 0.9em; 
    }
    .pagination .page-item.active .page-link {
        background-color: #007bff; 
        border-color: #007bff; 
        color: #fff; 
    }
    .pagination .page-item.disabled .page-link {
        color: #6c757d; 
    }
</style>
@endsection
