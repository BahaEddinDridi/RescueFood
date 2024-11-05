@extends('admin.layouts.app')

@section('content')
<div class="container-fluid p-4 mb-5 wow fadeIn" data-wow-delay="0.1s" style="margin-top: 100px">
    <h1 class="mb-5 text-center text-gradient fw-bold">🌟 Liste des Certifications</h1>

    <div class="d-flex justify-content-end mb-4">
        <a href="{{ route('admin.certifications.create') }}" class="btn btn-primary border-0 py-2 px-4 rounded-pill shadow">
            <i class="fas fa-plus-circle me-2"></i> Ajouter une certification
        </a>
    </div>

    <div class="row g-4">
        @forelse($certifications as $certification)
            <div class="col-md-6 col-lg-4">
                <!-- Changement de la couleur de fond de la carte et de la bordure -->
                <div class="card rounded-4 h-100 shadow-lg position-relative overflow-hidden" style="background-color: #ffffff; border-left: 8px solid #007bff;">
                    <div class="card-body d-flex flex-column align-items-center text-center p-4">
                        <div class="icon-circle text-warning mb-3" style="font-size: 2.5rem;">
                            <i class="fas fa-award"></i>
                        </div>
                        <h4 class="card-title text-dark fw-bold">{{ $certification->nom }}</h4>
                        <p class="card-text text-muted">{{ $certification->description ? Str::limit($certification->description, 100) : 'Pas de description disponible' }}</p>

                        <!-- Affichage du nom du produit lié -->
                        <p class="text-dark fw-bold mb-1">Produit : {{ $certification->produit->nom ?? 'Non spécifié' }}</p>

                        <!-- Affichage du nom de l'utilisateur associé au produit -->
                        <p class="text-muted small mb-1">Créé par : {{ $certification->produit->user->first_name ?? 'Non spécifié' }} {{ $certification->produit->user->last_name ?? '' }}</p>

                        <p class="text-muted small mb-1">🗓 Date de validation: {{ \Carbon\Carbon::parse($certification->date_validation)->format('d M Y') }}</p>
                        <!-- Couleurs personnalisées des badges -->
                        <span class="badge rounded-pill mt-2 px-3 py-2 text-uppercase shadow-sm
                            @switch($certification->statut)
                                @case('active')
                                    bg-success
                                    @break
                                @case('pending')
                                    bg-warning
                                    @break
                                @case('expired')
                                    bg-danger
                                    @break
                                @case('inactive')
                                    bg-secondary
                                    @break
                                @default
                                    bg-dark
                            @endswitch">
                            {{ ucfirst($certification->statut) }}
                        </span>
                    </div>
                    <div class="card-footer bg-transparent border-0 d-flex justify-content-around">
                        <a href="{{ route('admin.certifications.edit', $certification->id) }}" class="btn btn-outline-primary rounded-pill shadow-sm">
                            <i class="fas fa-edit"></i> Modifier
                        </a>
                        
                        <form action="{{ route('admin.certifications.destroy', $certification->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger rounded-pill shadow-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette certification ?');">
                                <i class="fas fa-trash-alt"></i> Supprimer
                            </button>
                        </form>
                    </div>
                    <div class="position-absolute top-0 end-0 m-2">
                        <span class="badge bg-primary text-white rounded shadow-sm px-3 py-1">{{ $certification->type }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle me-2"></i> Aucune certification disponible.
                </div>
            </div>
        @endforelse
    </div>
    
    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $certifications->links() }}
    </div>
</div>
@endsection
