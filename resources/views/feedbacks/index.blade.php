@extends('layouts.app')

@section('content')
<div class="container-fluid p-4 mb-5 wow fadeIn" data-wow-delay="0.1s" style="margin-top: 100px;">
    <h1 class="text-center mb-5">Liste des Feedbacks</h1>
    <div class="d-flex justify-content-end mb-4">
        <a href="{{ route('feedbacks.create') }}" class="btn btn-primary btn-lg"> <i class="fas fa-plus"></i> Ajouter un nouveau feedback</a>
    </div>

    <!-- Barre de recherche et boutons radio pour le filtrage -->
    <div class="mb-4 row">
    <div class="col-md-6 mb-3">
        <input type="text" id="searchInput" class="form-control form-control-lg" placeholder="Rechercher un feedback..." onkeyup="filterFeedbacks()">
    </div>
    <div class="col-md-6 d-flex justify-content-center align-items-center">
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-outline-success">
                <input type="radio" name="typeFilter" id="all" value="" checked onclick="filterFeedbacks()"> Tous les types
            </label>
            <label class="btn btn-outline-success">
                <input type="radio" name="typeFilter" id="don" value="don" onclick="filterFeedbacks()"> Don
            </label>
            <label class="btn btn-outline-success">
                <input type="radio" name="typeFilter" id="evenement" value="evenement" onclick="filterFeedbacks()"> Événement
            </label>
            <label class="btn btn-outline-success">
                <input type="radio" name="typeFilter" id="reservation" value="reservation" onclick="filterFeedbacks()"> Réservation
            </label>
        </div>
    </div>
</div>


    <!-- Cartes de feedback -->
    <div class="row" id="feedbackCards">
        @foreach ($feedbacks as $index => $feedback)
            <div class="col-md-4 mb-4 feedback-card" data-type="{{ $feedback->type_feedback }}">
                <div class="card shadow-sm h-100 border-0">
                    <div class="card-body">
                        <h5 class="card-title">Feedback #{{ $index + 1 }} </h5>
                        <span class="badge bg-primary mb-3">{{ ucfirst($feedback->type_feedback) }}</span>
                        <p class="card-text">{{ $feedback->contenu_feedback }}</p>
                        <p class="text-muted">Créé par : {{ $feedback->user->first_name ?? 'Inconnu' }} {{ $feedback->user->last_name ?? '' }}</p>
                        <p class="text-muted">Créé le : {{ $feedback->created_at->format('d/m/Y H:i') }}</p>

                        <!-- Affichage des étoiles selon la note -->
                        <div class="rating mb-3">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fa fa-star {{ $i <= $feedback->rating ? 'text-warning' : 'text-muted' }}"></i>
                            @endfor
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light">
                        <a href="{{ route('feedbacks.show', $feedback->id) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-eye"></i> Voir Détails
                        </a>
                        @if (Auth::id() == $feedback->user_id)
                        <div class="d-flex">
                            <a href="{{ route('feedbacks.edit', $feedback->id) }}" class="btn btn-sm btn-outline-info mr-2">
                                <i class="fas fa-edit"></i> Modifier
                            </a>
                            <form action="{{ route('feedbacks.destroy', $feedback->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce feedback ?');">
                                    <i class="fas fa-trash"></i> Supprimer
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
function filterFeedbacks() {
    let searchInput = document.getElementById('searchInput').value.toLowerCase();
    let typeFilter = document.querySelector('input[name="typeFilter"]:checked').value.toLowerCase();
    let cards = document.querySelectorAll('.feedback-card');

    cards.forEach(card => {
        let textContent = card.innerText.toLowerCase();
        let cardType = card.getAttribute('data-type').toLowerCase();

        // Afficher uniquement si le texte et le type correspondent
        let matchesSearch = textContent.includes(searchInput);
        let matchesType = (typeFilter === "" || cardType === typeFilter);

        card.style.display = (matchesSearch && matchesType) ? "" : "none";
    });
}
</script>

<style>
    /* Styles pour rendre l'affichage plus agréable */
    .feedback-card .card {
        transition: transform 0.3s, box-shadow 0.3s;
        border-radius: 10px;
    }

    .feedback-card .card:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .rating .fa-star {
        font-size: 18px;
    }

    .btn-group-toggle .btn {
        transition: background-color 0.3s, color 0.3s;
    }

    .btn-group-toggle .btn:hover,
    .btn-group-toggle .btn.active {
        background-color: #007bff;
        color: white;
    }

    .btn-outline-success:hover, .btn-outline-success.active {
        background-color: #28a745;
        color: white;
        border-color: #28a745;
    }

    /* Conserver les styles de bordure verte pour le bouton actif */
    .btn-outline-success.active {
        background-color: #28a745;
        color: white;
        border-color: #28a745;
    }
</style>
@endsection
