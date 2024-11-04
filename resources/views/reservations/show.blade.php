@extends('layouts.app')

@section('content')
<div class="container-fluid p-4 mb-5 wow fadeIn" data-wow-delay="0.1s" style="margin-top: 100px;">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h2>Détails de la Réservation</h2>
        </div>
    </div>

    <div class="d-flex justify-content-center"> <!-- Centrer la carte -->
        <div class="card shadow" style="width: 35rem;"> <!-- Élargir la carte -->
            <img src="{{ asset('img/Reservation.png') }}" class="card-img-top rounded-top" alt="Image Reservation">

            <div class="card-body">
                <h5 class="card-title text-center"> Réservation </h5>

                <div class="row">
                    <!-- Section Bénéficiaire -->
                    <div class="col-12 mb-3">
                        <div class="card border-primary">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-2 text-primary">Bénéficiaire</h6>
                                <p class="card-text">
                                    <strong>Nom :</strong> {{ $reservation->user->first_name ?? 'Non spécifié' }} {{ $reservation->user->last_name ?? '' }}<br>
                                    <strong>Email :</strong> {{ $reservation->user->email ?? 'Non spécifié' }}<br>
                                    <strong>Téléphone :</strong> {{ $reservation->user->phone_number ?? 'Non spécifié' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Section Don -->
                    <div class="col-12 mb-3">
                        <div class="card border-success">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-2 text-success">Don</h6>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><strong>Type d'aliment :</strong> {{ $reservation->don->type_aliment ?? 'Non spécifié' }}</li>
                                    <li class="list-group-item"><strong>Quantité :</strong> {{ $reservation->don->quantité ?? 'Non spécifié' }}</li>
                                    <li class="list-group-item"><strong>Date du Don :</strong> {{ $reservation->don->date_don ?? 'Non spécifiée' }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Section Réservation -->
                    <div class="col-12 mb-3">
                        <div class="card border-info">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-2 text-info">Réservation</h6>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><strong>Date de Réservation :</strong> {{ $reservation->date_reservation->format('d/m/Y H:i') }}</li>
                                    <li class="list-group-item"><strong>Statut de la Réservation :</strong> {{ ucfirst($reservation->statut_reservation) }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body text-center"> <!-- Centrer le bouton -->
                    <a href="{{ route('reservations.index') }}" class="btn btn-primary btn-lg">Retour à la Liste</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
