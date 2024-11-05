@extends('layouts.app')

@section('content')
<div class="container-fluid p-4 mb-5 wow fadeIn" data-wow-delay="0.1s" style="margin-top: 100px;">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h2>Détails du Feedback</h2>
        </div>
    </div>

    <div class="d-flex justify-content-center"> <!-- Centrer la carte -->
        <div class="card shadow" style="width: 35rem;"> <!-- Élargir la carte -->
            <img src="{{ asset('img/Feedback.png') }}" class="card-img-top rounded-top" alt="Image Feedback">

            <div class="card-body">
                <h5 class="card-title text-center">Feedback </h5>

                <div class="row">
                    <!-- Section Utilisateur -->
                    <div class="col-12 mb-3">
                        <div class="card border-primary">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-2 text-primary">Utilisateur</h6>
                                <p class="card-text">
                                    <strong>Nom :</strong> {{ $feedback->user->first_name ?? 'Non spécifié' }} {{ $feedback->user->last_name ?? '' }}<br>
                                    <strong>Email :</strong> {{ $feedback->user->email ?? 'Non spécifié' }}<br>
                                    <strong>Téléphone :</strong> {{ $feedback->user->phone_number ?? 'Non spécifié' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Section Feedback -->
                    <div class="col-12 mb-3">
                        <div class="card border-success">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-2 text-success">Feedback</h6>
                                <p class="card-text">
                                    <strong>Type de Feedback :</strong> {{ ucfirst($feedback->type_feedback) }}<br>
                                    <strong>Contenu :</strong> {{ $feedback->contenu_feedback ?? 'Non spécifié' }}<br>
                                    <strong>Date :</strong> {{ $feedback->created_at->format('d/m/Y H:i') }}<br>
                                    <strong>Note :</strong>
                                    <div id="star-rating" class="d-flex">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="star fa fa-star {{ $i <= $feedback->rating ? 'text-warning' : 'text-muted' }}" style="font-size: 24px;"></i>
                                        @endfor
                                    </div>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body text-center"> <!-- Centrer le bouton -->
                    <a href="{{ route('feedbacks.index') }}" class="btn btn-primary btn-lg">Retour à la Liste</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
