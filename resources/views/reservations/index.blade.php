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

    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Rechercher une réservation..." onkeyup="filterReservations()">
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
                            <span class="text-warning">En attente</span>
                            <i class="fas fa-hourglass-half text-warning me-2"></i>
                        
                        @elseif ($reservation->statut_reservation === 'confirmé')
                            <span class="text-primary">Confirmé</span>
                            <i class="fas fa-check-circle text-primary me-2"></i>

                        @elseif ($reservation->statut_reservation === 'completé')
                            <span class="text-success">Complété</span>
                            <i class="fas fa-check text-success me-2"></i>
                           
                        @elseif ($reservation->statut_reservation === 'annulee')
                            <span class="text-danger">Annulé</span>
                            <i class="fas fa-times-circle text-danger me-2"></i>
                           
                        @else
                            <span class="text-secondary">Inconnu</span>
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
    let input = document.getElementById('searchInput');
    let filter = input.value.toLowerCase();
    let cards = document.getElementById('reservationCards').getElementsByClassName('col-md-4');

    for (let i = 0; i < cards.length; i++) {
        let cardText = cards[i].textContent || cards[i].innerText;
        cards[i].style.display = cardText.toLowerCase().includes(filter) ? "" : "none";
    }
}
</script>
@endsection
