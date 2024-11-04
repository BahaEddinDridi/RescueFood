@extends('layouts.app')

@section('content')
<div class="container-fluid p-4 mb-5 wow fadeIn" data-wow-delay="0.1s" style="margin-top: 100px;">
    <h1 class="text-center mb-5" style="color: #4A4A4A;">Inventaire Donateur</h1>

    <div class="mb-3 text-center">
        <input type="text" id="search" class="form-control w-70 mx-auto" placeholder="Rechercher un article..." onkeyup="searchTable()" style="height: 50px;">
    </div>

    @if($userId)
        <div class="mb-4">
            <a href="{{ route('invertaireDonateurs.produits', ['userId' => $userId]) }}" class="btn btn-primary" style="padding: 10px 30px; font-size: 1.25rem;">
                Ajouter des produits
            </a>
        </div>
    @else
        <p class="text-danger text-center">Aucun identifiant d'utilisateur fourni.</p>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover" id="inventoryTable">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Nom de l'article</th>
                    <th scope="col">Quantité</th>
                    <th scope="col">Date de péremption</th>
                    <th scope="col">Localisation</th>
                    <th scope="col" style="width: 150px;">Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($invDonateur as $item)
            <tr>
                <td>{{ $item->nom_article }}</td>
                <td>{{ $item->quantité }}</td>
                <td>{{ $item->date_peremption }}</td>
                <td>{{ $item->localisation }}</td>
                <td>
                    <!-- Bouton Voir -->
                    <a href="{{ route('invertaireDonateurs.show', ['id' => $item->id, 'userId' => $userId]) }}" class="btn btn-outline-primary btn-sm" title="Voir les détails">
                        <i class="bi bi-eye"></i> <!-- Icône d'œil pour voir -->
                    </a>
                    <!-- Bouton Modifier -->
                    <a href="{{ route('invertaireDonateurs.edit', ['id' => $item->id, 'userId' => $userId]) }}" class="btn btn-outline-info btn-sm" title="Modifier">
                        <i class="bi bi-pencil"></i> <!-- Icône de crayon pour modifier -->
                    </a>
                    <!-- Bouton Supprimer -->
                    <form action="{{ route('invertaireDonateurs.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Êtes-vous sûr ?')" title="Supprimer">
                            <i class="bi bi-trash"></i> <!-- Icône de corbeille pour supprimer -->
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<style>
    .table {
        border-radius: 10px;
        overflow: hidden;
        background-color: #f8f9fa; /* Couleur de fond du tableau */
    }
    .table th, .table td {
        vertical-align: middle;
        font-size: 1.1em;
    }
    .table thead th {
        background-color: #343a40; /* Couleur de l'en-tête */
        color: white;
        text-align: center;
    }
    .table tbody tr:hover {
        background-color: #e9ecef; /* Couleur de survol */
    }
    .btn {
        border-radius: 5px; /* Arrondi des boutons */
    }
    #search {
        margin-bottom: 20px; /* Espace entre la barre de recherche et le tableau */
    }
</style>

<script>
    function searchTable() {
        let input = document.getElementById('search');
        let filter = input.value.toLowerCase();
        let table = document.getElementById('inventoryTable');
        let tr = table.getElementsByTagName('tr');

        for (let i = 1; i < tr.length; i++) { // Commencer à 1 pour ignorer l'en-tête
            let td = tr[i].getElementsByTagName('td');
            let found = false;

            for (let j = 0; j < td.length - 1; j++) { // Ignorer la colonne des actions
                if (td[j] && td[j].textContent.toLowerCase().indexOf(filter) > -1) {
                    found = true;
                    break;
                }
            }
            tr[i].style.display = found ? '' : 'none'; // Afficher ou cacher la ligne
        }
    }
</script>
@endsection
