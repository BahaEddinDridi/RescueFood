@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Inventaire des Produits de l'Utilisateur ID: {{ $user_id }}</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom de l'article</th>
                <th>Quantité</th>
                <th>Date de péremption</th>
                <th>Localisation</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($produits as $produit)
                <tr>
                    <td>{{ $produit->id }}</td>
                    <td>{{ $produit->nom_article }}</td>
                    <td>{{ $produit->quantité }}</td>
                    <td>{{ $produit->date_peremption }}</td>
                    <td>{{ $produit->localisation }}</td>
                    <td>
                        <a href="{{ route('admin.inventaireDonateur.edit', $produit->id) }}" class="btn btn-warning">Modifier</a>

                        <!-- Formulaire de suppression -->
                        <form action="{{ route('admin.inventaireDonateur.destroy', $produit->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    {{ $produits->links() }}
</div>
@endsection
