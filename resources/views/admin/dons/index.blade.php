@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Liste des Dons</h1>

    <!-- Bouton pour créer un nouveau don -->
    <a href="{{ route('admin.dons.create') }}" class="btn btn-success mb-3">Ajouter un Don</a>

    <!-- Liste des dons avec options de modification et de suppression -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Type d'Aliment</th>
                <th>Quantité</th>
                <th>Date de Péremption</th>
                <th>Date du Don</th>
                <th>Statut</th>
                <th>Utilisateur</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($don as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->type_aliment }}</td>
                    <td>{{ $item->quantité }}</td>
                    <td>{{ $item->date_peremption }}</td>
                    <td>{{ $item->date_don }}</td>
                    <td>{{ $item->statut }}</td>
                    <td>{{ $item->user->id ?? 'Utilisateur inconnu' }}</td>
                    <td>
                        <!-- Bouton pour modifier le don -->
                        <a href="{{ route('admin.dons.edit', $item->id) }}" class="btn btn-warning">Modifier</a>
                        
                        <!-- Formulaire pour supprimer le don -->
                        <form action="{{ route('admin.dons.destroy', $item->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce don ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    {{ $don->links() }}
</div>
@endsection
