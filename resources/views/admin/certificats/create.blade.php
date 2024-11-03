@extends('admin.layouts.app')

@section('content')
@if (auth()->check() && auth()->user()->role === 'admin')
    <!-- Afficher le formulaire -->
    <div class="container-fluid p-4 mb-5 wow fadeIn" data-wow-delay="0.1s" style="margin-top: 100px">
        <div class="row justify-content-center">
            <div class="col-md-8 ">
                <h1 class="text-center">Ajouter une Certification</h1>

         

                <form action="{{ route('admin.certifications.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nom">Nom</label>
                        <input type="text" name="nom" class="form-control" value="{{ old('nom') }}" >
                        <!-- Afficher l'erreur pour le champ nom -->
                        @error('nom')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                        <!-- Afficher l'erreur pour le champ description -->
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="date_validation">Date de validation</label>
                        <input type="date" name="date_validation" class="form-control" value="{{ old('date_validation') }}" >
                        <!-- Afficher l'erreur pour le champ date_validation -->
                        @error('date_validation')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="statut">Statut</label>
                        <select name="statut" class="form-control" >
                            <option value="" disabled selected>-- Sélectionner le statut --</option>
                            <option value="active" {{ old('statut') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('statut') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="pending" {{ old('statut') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="expired" {{ old('statut') == 'expired' ? 'selected' : '' }}>Expired</option>
                        </select>
                        <!-- Afficher l'erreur pour le champ statut -->
                        @error('statut')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="produit_id">Produit Alimentaire</label>
                        <select name="produit_id" class="form-control" >
                            <option value="" disabled selected>-- Sélectionner un produit --</option>
                            @foreach ($produits as $produit)
                                <option value="{{ $produit->id }}" {{ old('produit_id') == $produit->id ? 'selected' : '' }}>{{ $produit->nom }}</option>
                            @endforeach
                        </select>
                        <!-- Afficher l'erreur pour le champ produit_id -->
                        @error('produit_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-outline-primary border-2 py-2 px-4 mt-3 rounded-pill">Créer</button>
                </form>
            </div>
        </div>
    </div>
@else
    <p class="text-center">Vous n'êtes pas autorisé à créer des certifications. Connectez-vous en tant que donateur pour accéder à cette fonctionnalité.</p>
@endif

@endsection
