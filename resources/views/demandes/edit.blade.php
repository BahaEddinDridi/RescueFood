@extends('layouts.app')

@section('content')
<div class="container-fluid p-4 mb-5 wow fadeIn" data-wow-delay="0.1s" style="margin-top: 100px;">
<div class="container">
    
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4 text-center">Modifier la demande</h2>
        </div>
    <form action="{{ route('demandes.update', $demande->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        @if(Auth::user()->role === 'beneficiaire')
            <div class="form-group">
                <label for="beneficiaire_id">ID du bénéficiaire</label>
                <input type="number" name="beneficiaire_id" class="form-control" value="{{ $demande->beneficiaire_id }}" required>
            </div>
        @else
            <input type="hidden" name="beneficiaire_id" value="{{ $demande->beneficiaire_id }}">
        @endif
        
        <div class="form-group">
            <label for="type_aliment">Type d'aliment</label>
            @if(Auth::user()->role === 'beneficiaire')
                <input type="text" name="type_aliment" class="form-control" value="{{ $demande->type_aliment }}" required>
            @else
                <input type="text" name="type_aliment" class="form-control" value="{{ $demande->type_aliment }}" readonly>
            @endif
        </div>
        
        <div class="form-group">
            <label for="quantite">Quantité</label>
            @if(Auth::user()->role === 'beneficiaire')
                <input type="number" name="quantite" class="form-control" value="{{ $demande->quantite }}" required>
            @else
                <input type="number" name="quantite" class="form-control" value="{{ $demande->quantite }}" readonly>
            @endif
        </div>

        <div class="form-group">
            <label for="date_demande">Date de la demande</label>
            @if(Auth::user()->role === 'beneficiaire')
                <input type="date" name="date_demande" class="form-control" value="{{ $demande->date_demande }}" required>
            @else
                <input type="date" name="date_demande" class="form-control" value="{{ $demande->date_demande }}" readonly>
            @endif
        </div>

        <div class="form-group">
            <label for="statut">Statut</label>
            <select name="statut" class="form-control" required>
                <option value="en attente" {{ $demande->statut == 'en attente' ? 'selected' : '' }}>En attente</option>
                <option value="complétée" {{ $demande->statut == 'complétée' ? 'selected' : '' }}>Complétée</option>
            </select>
        </div>
        <div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('demandes.index') }}" class="btn btn-secondary">Retour</a>
        
        </div>
    </form>
</div>
</div>
@endsection
