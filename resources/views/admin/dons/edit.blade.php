@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Modifier le Don</h1>

    <!-- Affiche les erreurs de validation -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.dons.update', $don->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Sélection de l'utilisateur -->
        <div class="form-group">
            <label for="user_id">Utilisateur</label>
            <select name="user_id" id="user_id" class="form-control" required>
                <option value="">Sélectionnez un utilisateur</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $don->user_id == $user->id ? 'selected' : '' }}>
                    {{ $user->id }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Autres champs de don pré-remplis avec les valeurs actuelles -->
        <div class="form-group">
            <label for="type_aliment">Type d'aliment</label>
            <input type="text" name="type_aliment" id="type_aliment" class="form-control" required value="{{ $don->type_aliment }}">
        </div>

        <div class="form-group">
            <label for="quantité">Quantité</label>
            <input type="number" name="quantité" id="quantité" class="form-control" required min="1" value="{{ $don->quantité }}">
        </div>

        <div class="form-group">
            <label for="date_peremption">Date de péremption</label>
            <input type="date" name="date_peremption" id="date_peremption" class="form-control" required value="{{ $don->date_peremption }}">
        </div>

        <div class="form-group">
            <label for="date_don">Date du don</label>
            <input type="date" name="date_don" id="date_don" class="form-control" required value="{{ $don->date_don }}">
        </div>

        <!-- Champ statut avec liste déroulante -->
        <div class="form-group">
            <label for="statut">Statut</label>
            <select name="statut" id="statut" class="form-control" required>
                <option value="disponible" {{ $don->statut == 'disponible' ? 'selected' : '' }}>Disponible</option>
                <option value="récupéré" {{ $don->statut == 'récupéré' ? 'selected' : '' }}>Récupéré</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
    </form>
</div>
@endsection
