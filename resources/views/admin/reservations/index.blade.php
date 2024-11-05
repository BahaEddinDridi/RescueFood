@extends('admin.layouts.app')

@section('content')
<div class="container my-4">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
            <h5 class="card-title mb-0">Liste des Réservations</h5>
        </div>

        <!-- Search Bar -->
        <div class="card-body">
            <div class="mb-4 row align-items-center">
                <div class="col-md-6 mb-3">
                    <input type="text" id="searchInput" class="form-control border border-primary" placeholder="Rechercher une réservation..." onkeyup="filterReservations()">
                </div>
                <div class="col-md-6 d-flex justify-content-center align-items-center">
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-outline-secondary" id="statusAll">
                            <input type="radio" name="statusFilter" value="" checked onclick="filterReservations()"> Tous les Statuts
                        </label>
                        <label class="btn btn-outline-secondary">
                            <input type="radio" name="statusFilter" value="en_attente" onclick="filterReservations()"> En Attente
                        </label>
                        <label class="btn btn-outline-secondary">
                            <input type="radio" name="statusFilter" value="confirmé" onclick="filterReservations()"> Confirmé
                        </label>
                        <label class="btn btn-outline-secondary">
                            <input type="radio" name="statusFilter" value="completé" onclick="filterReservations()"> Complété
                        </label>
                        <label class="btn btn-outline-secondary">
                            <input type="radio" name="statusFilter" value="annulee" onclick="filterReservations()"> Annulé
                        </label>
                    </div>
                </div>
            </div>

            <table class="table table-hover my-0 text-center">
                <thead class="bg-light">
                    <tr>
                        <th>Bénéficiaire</th>
                        <th class="d-none d-xl-table-cell">Don</th>
                        <th class="d-none d-xl-table-cell">Date de Réservation</th>
                        <th class="d-none d-md-table-cell">Statut</th>
                        <th class="d-none d-md-table-cell">Actions</th>
                    </tr>
                </thead>
                <tbody id="reservationTable">
                    @foreach($reservations as $reservation)
                        <tr>
                            <td>{{ $reservation->user->first_name ?? 'Non spécifié' }} {{ $reservation->user->last_name ?? '' }}</td>
                            <td class="d-none d-xl-table-cell">{{ $reservation->don->type_aliment ?? 'Non spécifié' }}</td>
                            <td class="d-none d-xl-table-cell">{{ $reservation->date_reservation->format('d/m/Y') }}</td>
                            <td>
                                @php
                                    $badgeColor = [
                                        'annulee' => 'badge-danger',
                                        'completé' => 'badge-success',
                                        'en_attente' => 'badge-warning',
                                        'confirmé' => 'badge-primary'
                                    ][$reservation->statut_reservation] ?? 'badge-secondary';
                                @endphp
                                <span class="badge {{ $badgeColor }}">{{ $reservation->statut_reservation }}</span>
                            </td>
                            <td>
                                <a href="{{ route('admin.reservations.edit', $reservation->id) }}" class="btn btn-outline-warning btn-sm">Modifier</a>
                                <form action="{{ route('admin.reservations.destroy', $reservation->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette réservation ?');">Supprimer</button>
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
function filterReservations() {
    const searchInput = document.getElementById('searchInput').value.toLowerCase();
    const statusFilter = document.querySelector('input[name="statusFilter"]:checked').value;
    const rows = document.getElementById('reservationTable').getElementsByTagName('tr');

    for (const row of rows) {
        const rowText = row.textContent.toLowerCase();
        const rowStatus = row.querySelector(".badge").textContent.trim().toLowerCase();

        const matchesSearch = rowText.includes(searchInput);
        const matchesStatus = statusFilter === "" || rowStatus === statusFilter;

        row.style.display = (matchesSearch && matchesStatus) ? "" : "none";
    }
}
</script>

<style>
    /* Card Styling */
    .card {
        border-radius: 8px;
        overflow: hidden;
    }
    
    /* Table Styling */
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }

    /* Badge Colors */
    .badge-danger { background-color: #dc3545; }
    .badge-success { background-color: #28a745; }
    .badge-warning { background-color: #ffc107; }
    .badge-primary { background-color: #007bff; }

    /* Search and Filter Buttons */
    #searchInput {
        border-radius: 20px;
    }
    .btn-group-toggle .btn {
        border-radius: 20px;
    }

    /* Button Hover Effects */
    .btn-outline-secondary.active, .btn-outline-secondary:hover {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
    }
</style>
@endsection
