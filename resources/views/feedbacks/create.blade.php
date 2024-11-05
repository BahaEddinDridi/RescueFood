@extends('layouts.app')

@section('title', 'Ajouter un Commentaire')

@section('content')
<div class="container-fluid p-4 mb-5 wow fadeIn" data-wow-delay="0.1s" style="margin-top: 100px;">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4 text-center">Ajouter un Commentaire</h2>
        </div>
    </div>

    <form action="{{ route('feedbacks.store') }}" method="POST">
        @csrf

        <!-- Type de Feedback -->
        <div class="form-group mb-3">
            <label for="type_feedback">Type de Feedback</label>
            <select name="type_feedback" id="type_feedback" class="form-control" >
                <option value="">Sélectionnez un type</option>
                <option value="don" {{ old('type_feedback') == 'don' ? 'selected' : '' }}>Don</option>
                <option value="evenement" {{ old('type_feedback') == 'evenement' ? 'selected' : '' }}>Événement</option>
                <option value="reservation" {{ old('type_feedback') == 'reservation' ? 'selected' : '' }}>Réservation</option>
            </select>
            @error('type_feedback')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Contenu du Feedback avec Emoji -->
        <div class="form-group mb-3">
            <label for="contenu_feedback">Contenu du Feedback</label>
            <div class="emoji-picker mb-2">
                <!-- Sélecteur d'emoji -->
                <button type="button" class="btn btn-light" onclick="addEmoji('😊')">😊</button>
                <button type="button" class="btn btn-light" onclick="addEmoji('😐')">😐</button>
                <button type="button" class="btn btn-light" onclick="addEmoji('☹️')">☹️</button>
                <button type="button" class="btn btn-light" onclick="addEmoji('👍')">👍</button>
                <button type="button" class="btn btn-light" onclick="addEmoji('👎')">👎</button>
                <button type="button" class="btn btn-light" onclick="addEmoji('❤️')">❤️</button> <!-- Emoji cœur rouge -->
                <!-- Ajoutez plus d'emojis si nécessaire -->
            </div>
            <textarea name="contenu_feedback" id="contenu_feedback" class="form-control" rows="5" placeholder="Entrez le contenu de votre feedback" >{{ old('contenu_feedback') }}</textarea>
            @error('contenu_feedback')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Note en étoiles -->
        <div class="form-group mb-3">
            <label for="rating">Note :</label>
            <div id="star-rating" class="d-flex">
                @for ($i = 1; $i <= 5; $i++)
                    <i class="star fa fa-star" data-value="{{ $i }}" style="font-size: 24px; cursor: pointer; color: #ccc;"></i>
                @endfor
            </div>
            <input type="hidden" name="rating" id="rating" value="{{ old('rating', 0) }}">
            @error('rating')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="d-flex justify-content-between mt-4">
            <button type="submit" class="btn btn-success">Ajouter le Feedback</button>
            <a href="{{ route('feedbacks.index') }}" class="btn btn-primary">Retour à la Liste</a>
        </div>
    </form>
</div>

<script>
    // Fonction pour ajouter un emoji dans le champ de texte
    function addEmoji(emoji) {
        const feedbackTextarea = document.getElementById('contenu_feedback');
        feedbackTextarea.value += emoji;  // Ajoute l'emoji au texte actuel
        feedbackTextarea.focus();  // Met le champ en focus pour une expérience fluide
    }

    document.addEventListener('DOMContentLoaded', function () {
        const stars = document.querySelectorAll('#star-rating .star');
        const ratingInput = document.getElementById('rating');

        stars.forEach(star => {
            star.addEventListener('click', function () {
                const ratingValue = this.getAttribute('data-value');
                ratingInput.value = ratingValue;

                stars.forEach(s => s.style.color = '#ccc');
                for (let i = 0; i < ratingValue; i++) {
                    stars[i].style.color = '#FFD700';
                }
            });
        });
    });
</script>
@endsection
