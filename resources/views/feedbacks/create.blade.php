@extends('layouts.app')

@section('title', 'Ajouter un Feedback')

@section('content')
<div class="container-fluid p-4 mb-5 wow fadeIn" data-wow-delay="0.1s" style="margin-top: 100px;">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4 text-center">Ajouter un Feedback</h2>
        </div>
    </div>

    <!-- Formulaire d'ajout de feedback -->
    <form action="{{ route('feedbacks.store') }}" method="POST">
        @csrf <!-- Protection CSRF de Laravel -->

        <!-- Type de Feedback -->
        <div class="form-group mb-3">
            <label for="type_feedback">Type de Feedback</label>
            <select name="type_feedback" id="type_feedback" class="form-control" required>
                <option value="">Sélectionnez un type</option>
                <option value="don" {{ old('type_feedback') == 'don' ? 'selected' : '' }}>Don</option>
                <option value="evenement" {{ old('type_feedback') == 'evenement' ? 'selected' : '' }}>Événement</option>
                <option value="reservation" {{ old('type_feedback') == 'reservation' ? 'selected' : '' }}>Réservation</option>
            </select>
            @error('type_feedback')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Contenu du Feedback -->
        <div class="form-group mb-3">
            <label for="contenu_feedback">Contenu du Feedback</label>
            <textarea name="contenu_feedback" id="contenu_feedback" class="form-control" rows="5" placeholder="Entrez le contenu de votre feedback" required>{{ old('contenu_feedback') }}</textarea>
            @error('contenu_feedback')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="d-flex justify-content-between mt-4">
                <!-- Bouton Retour à la Liste -->
                <a href="{{ route('feedbacks.index') }}" class="btn btn-primary">Retour à la Liste</a>
                <!-- Bouton Mettre à jour -->
                <button type="submit" class="btn btn-success">Ajouter le Feedback</button>
            </div>
       

    </form>
</div>
@endsection
