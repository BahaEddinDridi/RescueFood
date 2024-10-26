@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Modifier la Certification</h1>

    <form action="{{ route('certificats.update', urlencode($sujet)) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" class="form-control" id="nom" name="nom" value="{{ $nom }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required>{{ $description }}</textarea>
        </div>

        <div class="form-group">
            <label for="date_validation">Date de Validation</label>
            <input type="date" class="form-control" id="date_validation" name="date_validation" value="{{ $date_validation }}" required>
        </div>

        <div class="form-group">
            <label for="statut">Statut</label>
            <select class="form-control" id="statut" name="statut" required>
                <option value="valide" {{ $statut == 'valide' ? 'selected' : '' }}>Valide</option>
                <option value="invalide" {{ $statut == 'invalide' ? 'selected' : '' }}>Invalide</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Mettre à jour</button>
        <a href="{{ route('certificats.index') }}" class="btn btn-secondary">Retour</a>
    </form>
</div>
@endsection
