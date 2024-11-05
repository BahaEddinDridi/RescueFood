@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Ajouter un Don</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.dons.store') }}" method="POST">
        @csrf
        
        <!-- Sélection de l'utilisateur -->
        <div class="form-group">
            <label for="user_id">Utilisateur</label>
            <select name="user_id" id="user_id" class="form-control">
                <option value="">Sélectionnez un utilisateur</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->id }}</option>
                @endforeach
            </select>
            @error('user_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Autres champs de don -->
        <div class="form-group">
            <label for="type_aliment">Type d'aliment</label>
            <input type="text" name="type_aliment" id="type_aliment" class="form-control" >
            @error('type_aliment')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="quantité">Quantité</label>
            <input type="number" name="quantité" id="quantité" class="form-control"  min="1">
            @error('quantité')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="date_peremption">Date de péremption</label>
            <input type="date" name="date_peremption" id="date_peremption" class="form-control">
            @error('date_peremption')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="date_don">Date du don</label>
            <input type="date" name="date_don" id="date_don" class="form-control" >
            @error('date_don')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Champ statut avec liste déroulante -->
        <div class="form-group">
            <label for="statut">Statut</label>
            <select name="statut" id="statut" class="form-control" >
                <option value="disponible">Disponible</option>
                <option value="récupéré">Récupéré</option>
            </select>
            @error('statut')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Ajouter le Don</button>
    </form>
</div>
@endsection
