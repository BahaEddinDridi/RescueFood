@extends('layouts.app')

@section('content')
<div class="container-fluid p-4 mb-5 wow fadeIn" data-wow-delay="0.1s" style="margin-top: 100px">
    <h1>Liste des Feedbacks</h1>
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('feedbacks.create') }}" class="btn btn-primary"> <i class="fas fa-plus"></i> Ajouter un nouveau feedback</a>
    </div>

    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Rechercher un feedback..." onkeyup="filterFeedbacks()">
    </div>

    <div class="row" id="feedbackCards">
        @foreach ($feedbacks as $index => $feedback)
            <div class="col-md-4 mb-4 feedback-card">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Feedback #{{ $index + 1 }} </h5>
                        <h6 class="card-subtitle mb-2 text-muted">Type: {{ $feedback->type_feedback }}</h6>
                        <p class="card-text">{{ $feedback->contenu_feedback }}</p>
                        <p class="text-muted">Créé par : {{ $feedback->user->first_name ?? 'Inconnu' }} {{ $feedback->user->last_name ?? '' }}</p> <!-- Affichage du prénom et du nom -->
                        <p class="text-muted">Créé le : {{ $feedback->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('feedbacks.show', $feedback->id) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-eye"></i> Voir Détails
                        </a>
                        @if (Auth::id() == $feedback->user_id) <!-- Vérification si l'utilisateur connecté est celui qui a créé le feedback -->
                        <a href="{{ route('feedbacks.edit', $feedback->id) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-edit"></i> Modifier
                        </a>
                        <form action="{{ route('feedbacks.destroy', $feedback->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce feedback ?');">
                                <i class="fas fa-trash"></i> Supprimer
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
function filterFeedbacks() {
    let input = document.getElementById('searchInput').value.toLowerCase();
    let cards = document.querySelectorAll('.feedback-card');

    cards.forEach(card => {
        let textContent = card.innerText.toLowerCase();
        card.style.display = textContent.includes(input) ? "" : "none";
    });
}
</script>
@endsection
