@extends('layouts.app')

@section('content')
<div class="container-fluid p-4 mb-5 wow fadeIn" data-wow-delay="0.1s" style="margin-top: 100px;">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4 text-center font-weight-bold text-uppercase">Détails du Don</h2>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg h-100" style="border-radius: 15px; overflow: hidden;">
                <div class="card-header text-center" style="background-color: #28a745; color: white; border-radius: 15px 15px 0 0;">
                    <h4 class="m-0">{{ $don->type_aliment }}</h4>
                </div>
                <div class="card-body" style="background: linear-gradient(to bottom, #e9ecef, #ffffff);">
                    <div class="mb-4 d-flex align-items-center border-bottom pb-2">
                        <i class="fas fa-calendar-alt mr-3" style="font-size: 1.5em; color: #28a745;"></i>
                        <strong>Date du Don :</strong>
                        <span class="float-right ml-auto text-secondary">{{ $don->date_don }}</span>
                    </div>
                    <div class="mb-4 d-flex align-items-center border-bottom pb-2">
                        <i class="fas fa-calendar-check mr-3" style="font-size: 1.5em; color: #ffc107;"></i>
                        <strong>Date de Préremption :</strong>
                        <span class="float-right ml-auto text-secondary">{{ $don->date_peremption }}</span>
                    </div>
                    <div class="mb-4 d-flex align-items-center border-bottom pb-2">
                        <i class="fas fa-box-open mr-3" style="font-size: 1.5em; color: #007bff;"></i>
                        <strong>Quantité :</strong>
                        <span class="float-right ml-auto text-secondary">{{ $don->quantité }} unités</span>
                    </div>
                    <div class="mb-4 d-flex align-items-center">
                        <i class="fas fa-info-circle mr-3" style="font-size: 1.5em; color: #17a2b8;"></i>
                        <strong>Statut :</strong>
                        <span class="float-right ml-auto">
                            <span class="badge {{ $don->statut === 'Actif' ? 'badge-success' : 'badge-danger' }}">
                                {{ ucfirst($don->statut) }}
                            </span>
                        </span>
                    </div>
                </div>
                <div class="card-footer text-center" style="background-color: #f8f9fa; border-radius: 0 0 15px 15px;">
                    <a href="{{ route('Dons.index') }}" class="btn btn-primary btn-lg" style="border-radius: 50px; padding: 10px 30px; transition: background-color 0.3s;">
                        <i class="fas fa-arrow-left mr-2"></i> Retour à la Liste des Dons
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ajout de styles CSS pour améliorer l'apparence -->
<style>
    .card {
        transition: transform 0.3s;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .badge-success {
        background-color: #28a745;
    }
    .badge-danger {
        background-color: #dc3545;
    }
</style>
@endsection
