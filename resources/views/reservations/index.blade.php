@extends('layouts.app')

@section('content')
<div class="container-fluid p-4 mb-5 wow fadeIn" data-wow-delay="0.1s" style="margin-top: 100px">
    <h1>Liste des réservations</h1>

    @if (Auth::check() && Auth::user()->role == 'beneficiaire')
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('reservations.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Ajouter une nouvelle réservation
        </a>
    </div>
    @endif

    @if ($errors->has('no_dons'))
        <div class="alert alert-warning">
            {{ $errors->first('no_dons') }}
        </div>
    @endif

    @if ($errors->has('duplicate'))
        <div class="alert alert-danger">
            {{ $errors->first('duplicate') }}
        </div>
    @endif

    <!-- Barre de recherche -->
    <div class="mb-4 row">
        <div class="col-md-6 mb-3">
            <input type="text" id="searchInput" class="form-control form-control-lg" placeholder="Rechercher une réservation..." onkeyup="filterReservations()">
        </div>
        <div class="col-md-6 d-flex justify-content-center align-items-center">
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-outline-success">
                    <input type="radio" name="statusFilter" id="all" value="" checked onclick="filterReservations()"> Tous les statuts
                </label>
                <label class="btn btn-outline-primary">
                    <input type="radio" name="statusFilter" id="en_attente" value="en_attente" onclick="filterReservations()"> En attente
                </label>
                <label class="btn btn-outline-primary">
                    <input type="radio" name="statusFilter" id="confirmé" value="confirmé" onclick="filterReservations()"> Confirmé
                </label>
                <label class="btn btn-outline-primary">
                    <input type="radio" name="statusFilter" id="completé" value="completé" onclick="filterReservations()"> Complété
                </label>
                <label class="btn btn-outline-primary">
                    <input type="radio" name="statusFilter" id="annulee" value="annulee" onclick="filterReservations()"> Annulé
                </label>
            </div>
        </div>
    </div>

    <div class="row" id="reservationCards">
        @foreach ($reservations as $index => $reservation)
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Réservation #{{ $index + 1 }}</h5>
                    <p class="card-text">
                        <strong>Bénéficiaire:</strong> {{ $reservation->user->first_name ?? 'Non spécifié' }} {{ $reservation->user->last_name ?? '' }}<br>
                        <strong>Type d'aliment:</strong> {{ $reservation->don->type_aliment ?? 'Non spécifié' }}<br>
                        <strong>Date:</strong> {{ $reservation->date_reservation }}<br>
                        <strong>Statut:</strong>
                        @if ($reservation->statut_reservation === 'en_attente')
                            <span class="text-warning status">en_attente</span>
                            <i class="fas fa-hourglass-half text-warning me-2"></i>
                        @elseif ($reservation->statut_reservation === 'confirmé')
                            <span class="text-primary status">confirmé</span>
                            <i class="fas fa-check-circle text-primary me-2"></i>
                        @elseif ($reservation->statut_reservation === 'completé')
                            <span class="text-success status">completé</span>
                            <i class="fas fa-check text-success me-2"></i>
                        @elseif ($reservation->statut_reservation === 'annulee')
                            <span class="text-danger status">annulee</span>
                            <i class="fas fa-times-circle text-danger me-2"></i>
                        @else
                            <span class="text-secondary status">inconnu</span>
                            <i class="fas fa-question-circle text-secondary me-2"></i>
                        @endif
                    </p>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('reservations.show', $reservation->id) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-eye"></i> Voir Détails
                        </a>
                        @if (Auth::check() && Auth::user()->role == 'beneficiaire' && Auth::id() == $reservation->beneficiare_id)
                            <a href="{{ route('reservations.edit', $reservation->id) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-edit"></i> Modifier
                            </a>
                            <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette réservation ?');">
                                    <i class="fas fa-trash"></i> Supprimer
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
function filterReservations() {
    let searchInput = document.getElementById('searchInput').value.toLowerCase();
    let statusFilter = document.querySelector('input[name="statusFilter"]:checked').value;
    let cards = document.getElementById('reservationCards').getElementsByClassName('col-md-4');

    for (let i = 0; i < cards.length; i++) {
        let cardText = cards[i].textContent.toLowerCase();
        let cardStatus = cards[i].querySelector(".status").textContent.trim().toLowerCase();

        // Vérifier si le texte de recherche est présent dans le texte de la carte
        let matchesSearch = cardText.includes(searchInput);

        // Vérifier si le statut correspond au filtre sélectionné
        let matchesStatus = (statusFilter === "") || (cardStatus === statusFilter);

        cards[i].style.display = (matchesSearch && matchesStatus) ? "" : "none";
    }
}
</script>

<style>
    /* Styles pour les boutons de filtre */
    .btn-outline-primary:hover, .btn-outline-primary.active {
        background-color: #28a745;
        color: white;
        border-color: #28a745;
    }

    /* Style pour les boutons actifs */
    .btn-outline-success.active {
        background-color: #28a745;
        color: white;
        border-color: #28a745;
    }
</style>
@endsection
