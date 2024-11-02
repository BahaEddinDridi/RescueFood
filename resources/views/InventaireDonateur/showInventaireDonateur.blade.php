@extends('layouts.app')

@section('content')

<div class="container-fluid p-4 mb-5 wow fadeIn" data-wow-delay="0.1s" style="margin-top: 100px;">

    <div class="row">
        <div class="col-12">
            <h2 class="mb-4 text-center">Détails de l'article</h2>
        </div>
    </div>

    @if($invDonateur)
        <div class="card">
            <div class="card-header text-center">
                <h4>{{ $invDonateur->nom_article }}</h4>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Date de Préremption :</strong>
                    <span class="float-right">{{ $invDonateur->date_peremption }}</span>
                </div>
                <div class="mb-3">
                    <strong>Quantité :</strong>
                    <span class="float-right">{{ $invDonateur->quantité }}</span>
                </div>
                <div class="mb-3">
                    <strong>Localisation :</strong>
                    <span class="float-right">{{ ucfirst($invDonateur->localisation) }}</span>
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('invertaireDonateurs.index', ['userId' => $userId]) }}" class="btn btn-primary">Retour à la Liste des Dons</a>
            </div>
        </div>
    @else
        <div class="alert alert-danger text-center">
            <strong>Erreur :</strong> Cet article n'existe pas.
        </div>
    @endif

</div>

@endsection
