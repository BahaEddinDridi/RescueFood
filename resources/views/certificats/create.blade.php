@extends('layouts.app')

@section('content')
    <div class="container-fluid p-4 mb-5 wow fadeIn" data-wow-delay="0.1s" style="margin-top: 100px">
       
        <div class="row justify-content-center">
       
        <div class="col-md-8 ">
        <h1 class="text-center">Ajouter une Certification</h1>
        <!-- Formulaire de création d'une certification -->
        <form action="{{ route('certifications.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" name="nom" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label for="date_validation">Date de validation</label>
                <input type="date" name="date_validation" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="statut">Statut</label>
                <select name="statut" class="form-control" required>
                    <option value="" disabled selected>-- Sélectionner le statut --</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="pending">Pending</option>
                    <option value="expired">Expired</option>
                </select>
            </div>

            <div class="form-group mb-4">
                <label for="produit_id">Produit Alimentaire</label>
                <select name="produit_id" class="form-control" required>
                    <option value="" disabled selected>-- Sélectionner un produit --</option>
                    @foreach ($produits as $produit)
                        <option value="{{ $produit->id }}">{{ $produit->nom }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-outline-primary border-2 py-2 px-4 mt-3 rounded-pill">Créer</button>
           
        </form>
</div ></div>
    </div>
@endsection
