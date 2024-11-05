@extends('layouts.app')

@section('content')
<div class="container-fluid p-4 mb-5" style="margin-top: 100px;">
    
    <!-- Barre de Recherche Dynamique -->
    <div class="input-group mb-4 w-75 mx-auto">
        <input type="text" id="searchInput" class="form-control form-control-lg" placeholder="Rechercher un don par type, date ou statut..." aria-label="Search Donations" style="height: 50px;">
        <div class="input-group-append">
            <a class="btn btn-primary text-white d-flex align-items-center justify-content-center" style="height: 50px; padding: 0 20px; font-size: 1.5em;">
                Recherche
            </a>
        </div>
    </div>

    <!-- Bouton Ajouter un Don -->
    <div class="mb-4 d-flex justify-content-end">
        <a class="btn btn-primary btn-lg shadow" href="{{ route('Dons.create') }}" style="font-size: 1.25em; padding: 15px 30px; border-radius: 50px;">
            <i class="fas fa-plus-circle mr-2"></i> Ajouter un Don
        </a>
    </div>
    
    <div class="row" id="donationContainer">
        @php
            $backgroundImages = [
                'img/Don/1.jpg',
                'img/Don/2.png',
                'img/Don/3.png',
                'img/Don/4.png',
                'img/Don/5.png',
                'img/Don/6.png',
            ];
        @endphp

        @foreach($don as $index => $item)
        <div class="col-md-6 col-lg-4 mb-4 donation-item" data-type="{{ $item->type_aliment }}" data-date="{{ $item->date_don }}" data-status="{{ $item->statut }}">
            <div class="card border-0 shadow-lg h-100" style="border-radius: 15px; overflow: hidden; position: relative;">
                
                <div class="card-img-top" style="background-image: url('{{ $backgroundImages[$index % count($backgroundImages)] }}'); height: 150px; background-size: cover; background-position: center;">
                    <div class="overlay" style="background: rgba(0, 0, 0, 0.5); height: 100%;"></div>
                </div>
                
                <div class="card-body text-center" style="position: relative; z-index: 1;">
                    <div class="icon-container bg-success text-white d-flex justify-content-center align-items-center mx-auto mb-3" style="width: 60px; height: 60px; border-radius: 50%; font-size: 1.5em;">
                        <i class="fas fa-bread-slice"></i>
                    </div>
                    <h5 class="card-title mb-2">{{ $item->type_aliment }}</h5>
                    <p class="card-subtitle text-muted mb-3">Offert par l'entreprise</p>
                    <p class="card-text mb-1"><strong>Date du don:</strong> {{ $item->date_don }}</p>
                    <p class="card-text mb-1"><strong>Date de préremption:</strong> {{ $item->date_peremption }}</p>
                    <p class="card-text mb-1"><strong>Quantité:</strong> {{ $item->quantité }}</p>
                    <p class="card-text mb-1"><strong>Statut:</strong> {{ $item->statut }}</p>
                    
                    <div class="d-flex justify-content-center mt-4">
                        <a href="{{ route('Dons.show', $item->id) }}" class="btn btn-outline-warning btn-sm mx-1">Voir</a>
                        <a href="{{ route('Dons.edit', $item->id) }}" class="btn btn-outline-info btn-sm mx-1">Modifier</a>
                        <form action="{{ route('Dons.destroy', $item->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm mx-1" onclick="return confirm('Vous êtes sûr?')">Supprimer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination Links -->
    <div class="d-flex justify-content-center mt-4">
        {{ $don->links('pagination::bootstrap-4') }}
    </div>
</div>

<script>
// JavaScript pour la Recherche Dynamique
document.getElementById('searchInput').addEventListener('keyup', function() {
    const filter = this.value.toLowerCase();
    const items = document.querySelectorAll('.donation-item');

    items.forEach(item => {
        const type = item.getAttribute('data-type').toLowerCase();
        const date = item.getAttribute('data-date').toLowerCase();
        const status = item.getAttribute('data-status').toLowerCase();
        
        if (type.includes(filter) || date.includes(filter) || status.includes(filter)) {
            item.style.display = '';
        } else {
            item.style.display = 'none';
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
