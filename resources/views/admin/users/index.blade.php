@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="card flex-fill">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Liste des utilisateurs</h5>
            <a href="{{ route('admin.users.create') }}" class="btn btn-success">Ajouter un utilisateur</a>
        </div>
        <table class="table table-hover my-0">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th class="d-none d-xl-table-cell">Email</th>
                    <th class="d-none d-xl-table-cell">Organization</th>
                    <th class="d-none d-md-table-cell">Rôle</th>
                    <th class="d-none d-md-table-cell">Date d'Inscription</th>
                    <th class="d-none d-md-table-cell">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                    <td class="d-none d-xl-table-cell">{{ $user->email }}</td>
                    <td class="d-none d-xl-table-cell">{{ $user->association_name }}</td>
                    <td class="d-none d-md-table-cell">{{ ucfirst($user->role) }}</td>
                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-primary">Consulter le profil</a>
                        <a href="{{ route('admin.inventaireDonateur.index', $user->id) }}" class="btn btn-primary">Consulter l'inventaire</a>
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning">Modifier</a>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">Supprimer</button>
                        </form>
                        
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
