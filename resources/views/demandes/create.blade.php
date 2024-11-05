@extends('layouts.app')
@section('title', 'Add demande')
@section('content')

<div class="container-fluid p-4 mb-5 wow fadeIn" data-wow-delay="0.1s" style="margin-top: 100px;">
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4 text-center">Créer une nouvelle demande</h2>
        </div>
    </div>
  
    <form action="{{ route('demandes.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @if(Auth::user()->role === 'donateur')
        <div class="form-group">
            <label for="beneficiaire_id">Bénéficiaire</label>
            <select name="beneficiaire_id" class="form-control" required>
                <option value="" disabled selected>Choisissez un bénéficiaire</option>
                @foreach($beneficiaries as $beneficiary)
                    <option value="{{ $beneficiary->id }}">{{ $beneficiary->name }}</option>
                @endforeach
            </select>
            @error('beneficiaire_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        @endif

        <div class="form-group">
            <label for="type_aliment">Type d'aliment</label>
            <input type="text" name="type_aliment" class="form-control"  pattern="[A-Za-z\s]+" >
            @error('type_aliment')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="quantite">Quantité</label>
            <input type="number" name="quantite" class="form-control"   placeholder="Entrez une quantité valide">
            @error('quantite')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="date_demande">Date de la demande</label>
            <input type="date" name="date_demande" class="form-control" >
            @error('date_demande')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="statut">Statut</label>
            <select name="statut" class="form-control" >
                <option value="en attente">En attente</option>
                <option value="complétée">Complétée</option>
            </select>
            @error('statut')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div>
        <button type="submit" class="btn btn-primary">Créer</button>
        <a href="{{ route('demandes.index') }}" class="btn btn-secondary">Retour</a>
        </div>
    </form>
</div>
</div>
@endsection
