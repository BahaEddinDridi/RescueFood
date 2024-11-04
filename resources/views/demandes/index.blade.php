@extends('layouts.app')

@section('content')
<div class="container-fluid p-4 mb-5 wow fadeIn" data-wow-delay="0.1s" style="margin-top: 100px;">
    <h1 class="mb-4 text-center" style="font-weight: 700; color: #4a4a4a;">📋 Liste des Demandes</h1>

    <!-- Filtrage par statut -->
    <div class="mb-4">
        <form method="GET" action="{{ route('demandes.index') }}">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="statut[]" value="en attente" id="statut-en-attente" {{ request()->input('statut') && in_array('en attente', request()->input('statut')) ? 'checked' : '' }}>
                <label class="form-check-label" for="statut-en-attente">En Attente</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="statut[]" value="complétée" id="statut-complete" {{ request()->input('statut') && in_array('complétée', request()->input('statut')) ? 'checked' : '' }}>
                <label class="form-check-label" for="statut-complete">Complétée</label>
            </div>
            <button type="submit" class="btn btn-primary">Filtrer</button>
        </form>
    </div>

    <!-- Add Button (Visible only for Beneficiaries) -->
    @if(Auth::user()->role === 'beneficiaire')
        <div class="d-flex justify-content-end mb-4">
            <a href="{{ route('demandes.create') }}" class="btn btn-success btn-lg shadow-sm rounded-pill px-4">
                <i class="fas fa-plus-circle"></i> Ajouter une Demande
            </a>
        </div>
    @endif

    <!-- Card Layout for each "Demande" -->
    <div class="row">
        @foreach($demandes as $demande)
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100 border-0 demande-card">
                <div class="card-body p-4">
                    <!-- Icon and Title -->
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-circle me-3">
                            <i class="fas fa-utensils fa-lg text-white"></i>
                        </div>
                        <h5 class="card-title mb-0 text-dark" style="font-weight: bold;">{{ $demande->type_aliment }}</h5>
                    </div>

                    <p class="card-text text-muted mb-2"><strong>Quantité:</strong> {{ $demande->quantite }}</p>
                    <p class="card-text text-muted mb-2"><strong>Date:</strong> {{ $demande->date_demande }}</p>
                    <p class="card-text">
                        <span class="badge {{ $demande->statut === 'en attente' ? 'bg-warning text-dark' : 'bg-success text-white' }} px-3 py-1">
                            {{ ucfirst($demande->statut) }}
                        </span>
                    </p>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('demandes.edit', $demande->id) }}" class="btn btn-outline-primary btn-sm shadow-sm rounded-pill">
                            <i class="fas fa-pen"></i> Modifier
                        </a>
                        <form action="{{ route('demandes.destroy', $demande->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            @if(Auth::user()->role === 'beneficiaire')
                            <button type="submit" class="btn btn-outline-danger btn-sm shadow-sm rounded-pill" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette demande ?');">
                                <i class="fas fa-trash-alt"></i> Supprimer
                            </button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Styles -->
<style>
    .demande-card {
        border-radius: 15px;
        background: linear-gradient(135deg, #f7f9fc, #e1e8f0);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .demande-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }

    .icon-circle {
        width: 50px;
        height: 50px;
        background-color: #007bff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .badge.bg-warning {
        background-color: #ffc107;
        font-weight: 600;
    }

    .badge.bg-success {
        background-color: #28a745;
        font-weight: 600;
    }

    .btn-outline-primary {
        color: #007bff;
        border-color: #007bff;
    }
    .btn-outline-primary:hover {
        background-color: #007bff;
        color: white;
    }

    .btn-outline-danger {
        color: #dc3545;
        border-color: #dc3545;
    }
    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: white;
    }
</style>
@endsection
