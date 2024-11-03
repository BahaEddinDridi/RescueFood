@extends('layouts.app')

@section('content')
<div class="container-fluid p-4 mb-5 wow fadeIn" data-wow-delay="0.1s" style="margin-top: 100px">
    <h1>Liste des Certifications</h1>

    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('certifications.create') }}" class="btn btn-primary border-2 py-2 px-4 rounded-pill">
            <i class="fas fa-plus me-2"></i> Ajouter une nouvelle certification
        </a>
    </div>

    <div class="row">
        @forelse($certifications as $certification)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <div>
                            <i class="fas fa-award fa-3x text-warning mb-4" alt="Icône de certification"></i>
                        </div>
                        <h5 class="card-title">{{ $certification->nom }}</h5>
                        <p class="card-text">{{ $certification->description ? Str::limit($certification->description, 100) : 'Pas de description disponible' }}</p>
                        <p class="text-muted">Date de validation: {{ \Carbon\Carbon::parse($certification->date_validation)->format('d M Y') }}</p>
                        <p class="text-muted">
                            Statut: 
                            <span class="badge 
                                {{ $certification->statut === 'validé' ? 'bg-success' : ($certification->statut === 'en attente' ? 'bg-warning' : 'bg-danger') }}">
                                {{ ucfirst($certification->statut) }}
                            </span>
                        </p>
                    </div>

                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('certifications.show', $certification->id) }}" class="btn btn-outline-info rounded-pill">
                            <i class="fas fa-eye"></i> Voir
                        </a>

                     
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    Aucune certification disponible.
                </div>
            </div>
        @endforelse

        <div class="mt-4">
            {{ $certifications->links() }} <!-- Pagination -->
        </div>
    </div>
</div>
@endsection
