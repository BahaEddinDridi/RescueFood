@extends('layouts.app') 

@section('title', 'Tous les Produits Approuvés')

@section('content')
    <div class="p-4 mb-5" data-wow-delay="0.1s" style="margin-top: 100px;">
        <h1>Tous les produits</h1>

        <!-- Formulaire de recherche -->
        <form method="GET" action="{{ route('produitAlimentaire.index') }}" class="mb-4">
            <div class="input-group rounded">
                <input type="search" name="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" value="{{ request()->input('search') }}" />
                <span class="input-group-text border-0" id="search-addon">
                    <i class="fas fa-search"></i>
                </span>
            </div>
        </form>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('waiting_for_approval'))
            <div class="alert alert-warning">
                {{ session('waiting_for_approval') }}
            </div>
        @endif

        @if ($produitAlimentaire->count())
        <div class="row">
            @foreach ($produitAlimentaire as $produit)
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4"> 
                    <div class="card border-light shadow-sm">
                        <div class="position-relative">
                            @if (!empty($produit->image_url))
                                <img src="{{ asset($produit->image_url) }}" alt="{{ $produit->nom }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                            @else
                                <img src="https://via.placeholder.com/300" alt="Image non disponible" class="card-img-top" style="height: 200px; object-fit: cover;">
                            @endif
                        </div>

                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $produit->nom }}</h5>
                            <p class="card-text">Type: {{ $produit->type ?? 'Non spécifié' }}</p>
                            <p class="card-text">Quantité: {{ $produit->quantite }}</p>
                            <p class="card-text">Date d'expiration: {{ $produit->date_peremption }}</p>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <a class="btn btn-outline-primary rounded-pill" href="{{ route('produitAlimentaire.show', $produit->id) }}">
                                <i class="fa fa-eye"></i> Voir les détails
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @else
            <p>Aucun produit approuvé disponible. <a href="{{ route('produitAlimentaire.create') }}">Ajouter un produit maintenant!</a></p>
        @endif
    </div>
@endsection
