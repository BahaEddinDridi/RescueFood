@extends('layouts.app')

@section('title', 'All Products')

@section('content')
    <div class="p-4 mb-5" data-wow-delay="0.1s" style="margin-top: 100px;">
        <h1>Mes produits</h1>

        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('produitAlimentaire.create') }}" class="btn btn-primary border-2 py-2 px-4 rounded-pill">
                <i class="fas fa-plus me-2"></i> Ajouter un produit
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($produitAlimentaire->count())
            <div class="row">
                @foreach ($produitAlimentaire as $produit)
                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4"> 
                        <div class="card border-light shadow-sm">
                            <div class="position-relative">
                                @if (!empty($produit->image_url))
                                    <img src="{{ asset($produit->image_url) }}" alt="{{ $produit->nom }} - Image" class="card-img-top" style="height: 200px; object-fit: cover;">
                                @else
                                    <img src="https://via.placeholder.com/300" alt="Image non disponible" class="card-img-top" style="height: 200px; object-fit: cover;">
                                @endif
                            </div>

                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $produit->nom }}</h5>
                                <p class="card-text">Type: {{ $produit->type ?? 'Non spécifié' }}</p>
                                <p class="card-text">Quantité: {{ $produit->quantite }}</p>
                                <p class="card-text">Date d'expiration: {{ \Carbon\Carbon::parse($produit->date_peremption)->format('d-m-Y') }}</p>
                                @if ($produit->categorie)
                                    <p class="card-text">Catégorie: {{ $produit->categorie }}</p>
                                @endif
                                
                                @if (!$produit->approuve)
                                    <div class="alert alert-warning mt-2">
                                        Ce produit est en attente d'approbation.
                                    </div>
                                @endif
                            </div>
                            <div class="card-footer d-flex justify-content-between">
                                <a class="btn btn-outline-primary" href="{{ route('produitAlimentaire.show', $produit->id) }}">
                                    <i class="fa fa-eye"></i> Voir les détails
                                </a>
                                <a class="btn btn-outline-warning" href="{{ route('produitAlimentaire.edit', $produit->id) }}">
                                    <i class="fa fa-edit"></i> Éditer
                                </a>
                                <form action="{{ route('produitAlimentaire.destroy', $produit->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Tu es sûr?')" title="Supprimer" class="btn btn-outline-danger">
                                        <i class="fas fa-trash"></i> Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p>Aucun produit disponible. <a href="{{ route('produitAlimentaire.create') }}">Ajouter un produit maintenant!</a></p>
        @endif
    </div>
@endsection
