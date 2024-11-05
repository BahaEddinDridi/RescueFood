@extends('admin.layouts.app')

@section('content')
<div class="container my-5">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Liste des Commentaires</h4>
        </div>

        <!-- Barre de recherche et filtres -->
        <div class="card-body">
            <div class="row mb-4 align-items-center">
                <div class="col-md-6">
                    <input type="text" id="searchInput" class="form-control form-control-lg border border-secondary rounded-pill" placeholder="Rechercher un commentaire..." onkeyup="filterFeedbacks()">
                </div>
                <div class="col-md-6 d-flex justify-content-center">
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-outline-primary active rounded-pill px-4">
                            <input type="radio" name="typeFilter" id="all" value="" checked onclick="filterFeedbacks()"> Tous les types
                        </label>
                        <label class="btn btn-outline-primary rounded-pill px-4">
                            <input type="radio" name="typeFilter" id="don" value="don" onclick="filterFeedbacks()"> Don
                        </label>
                        <label class="btn btn-outline-primary rounded-pill px-4">
                            <input type="radio" name="typeFilter" id="evenement" value="evenement" onclick="filterFeedbacks()"> Événement
                        </label>
                        <label class="btn btn-outline-primary rounded-pill px-4">
                            <input type="radio" name="typeFilter" id="reservation" value="reservation" onclick="filterFeedbacks()"> Réservation
                        </label>
                    </div>
                </div>
            </div>

            <!-- Table des commentaires -->
            <table class="table table-striped table-hover">
                <thead class="bg-light">
                    <tr>
                        <th>User ID</th>
                        <th class="d-none d-xl-table-cell">Type de commentaire</th>
                        <th class="d-none d-xl-table-cell">Contenu</th>
                        <th>Notation</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="feedbackTable">
                    @foreach($feedbacks as $feedback)
                        <tr class="feedback-row" data-type="{{ $feedback->type_feedback }}">
                            <td>{{ $feedback->user_id ?? 'N/A' }}</td>
                            <td class="d-none d-xl-table-cell">{{ ucfirst($feedback->type_feedback) ?? 'N/A' }}</td>
                            <td class="d-none d-xl-table-cell">{{ Str::limit($feedback->contenu_feedback, 50) ?? 'N/A' }}</td>
                            <td>
                                <div class="rating mb-3">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fa fa-star {{ $i <= $feedback->rating ? 'text-warning' : 'text-muted' }}"></i>
                                @endfor
                            </div>
                            </td>
                            
                            <td>
                                <a href="{{ route('admin.feedbacks.edit', $feedback->id) }}" class="btn btn-sm btn-outline-warning rounded-pill">Modifier</a>
                                <form action="{{ route('admin.feedbacks.destroy', $feedback->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?');">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function filterFeedbacks() {
    const searchInput = document.getElementById('searchInput').value.toLowerCase();
    const typeFilter = document.querySelector('input[name="typeFilter"]:checked').value;
    const rows = document.querySelectorAll('.feedback-row');

    rows.forEach(row => {
        const textContent = row.innerText.toLowerCase();
        const rowType = row.getAttribute('data-type').toLowerCase();
        const matchesSearch = textContent.includes(searchInput);
        const matchesType = typeFilter === "" || rowType === typeFilter;

        row.style.display = (matchesSearch && matchesType) ? "" : "none";
    });
}
</script>

<style>
    .card {
        border-radius: 10px;
    }

    .card-header {
        border-radius: 10px 10px 0 0;
    }

    .table-hover tbody tr:hover {
        background-color: #f1f4f8;
    }

    .btn-group-toggle .btn {
        transition: background-color 0.3s, color 0.3s;
    }

    .btn-outline-primary:hover, .btn-outline-primary.active {
        background-color: #0069d9;
        color: white;
    }

    /* Style pour les boutons d'action */
    .btn-outline-warning {
        color: #856404;
        border-color: #ffc107;
    }

    .btn-outline-warning:hover {
        background-color: #ffc107;
        color: #fff;
    }

    .btn-outline-danger {
        color: #721c24;
        border-color: #f5c6cb;
    }

    .btn-outline-danger:hover {
        background-color: #f5c6cb;
        color: #721c24;
    }
</style>
@endsection
