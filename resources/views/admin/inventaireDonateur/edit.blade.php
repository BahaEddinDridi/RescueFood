@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Modifier le Produit: {{ $produit->nom_article }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.inventaireDonateur.update', $produit->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nom_article">Nom de l'article</label>
            <input type="text" name="nom_article" id="nom_article" class="form-control" value="{{ $produit->nom_article }}" >
            @error('nom_article')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="quantité">Quantité</label>
            <input type="number" name="quantité" id="quantité" class="form-control" value="{{ $produit->quantité }}" min="1">
            @error('quantité')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="date_peremption">Date de péremption</label>
            <input type="date" name="date_peremption" id="date_peremption" class="form-control" value="{{ $produit->date_peremption }}">
            @error('date_peremption')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="localisation">Localisation</label>
            <input type="text" name="localisation" id="localisation" class="form-control" value="{{ $produit->localisation }}">
            @error('localisation')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour le Produit</button>
    </form>
</div>
@endsection
