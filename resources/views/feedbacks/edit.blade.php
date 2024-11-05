@extends('layouts.app')

@section('content')
<div class="container-fluid p-4 mb-5 wow fadeIn" data-wow-delay="0.1s" style="margin-top: 100px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4 text-center">Modifier le Feedback</h2>
            </div>
        </div>
        <form action="{{ route('feedbacks.update', $feedback->id) }}" method="POST" onsubmit="return validateForm()">
            @csrf
            @method('PUT') <!-- Méthode PUT pour la mise à jour -->

            <!-- Type de Feedback -->
            <div class="form-group mb-3">
                <label for="type_feedback">Type de Feedback</label>
                <select name="type_feedback" id="type_feedback" class="form-control" required>
                    <option value="don" {{ $feedback->type_feedback == 'don' ? 'selected' : '' }}>Don</option>
                    <option value="evenement" {{ $feedback->type_feedback == 'evenement' ? 'selected' : '' }}>Événement</option>
                    <option value="reservation" {{ $feedback->type_feedback == 'reservation' ? 'selected' : '' }}>Réservation</option>
                </select>
                @error('type_feedback')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Contenu du Feedback -->
            <div class="form-group mb-3">
                <label for="contenu_feedback">Contenu du Feedback</label>
                <textarea name="contenu_feedback" id="contenu_feedback" class="form-control" rows="4" required>{{ old('contenu_feedback', $feedback->contenu_feedback) }}</textarea>
                @error('contenu_feedback')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Note en étoiles -->
            <div class="form-group mb-3">
                <label for="rating">Note :</label>
                <div id="star-rating" class="d-flex">
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="star fa fa-star {{ $i <= $feedback->rating ? 'text-warning' : 'text-muted' }}" data-value="{{ $i }}" style="font-size: 24px; cursor: pointer;"></i>
                    @endfor
                </div>
                <input type="hidden" name="rating" id="rating" value="{{ old('rating', $feedback->rating) }}">
                @error('rating')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Bouton de mise à jour -->
            <button type="submit" class="btn btn-primary">Mettre à jour le Feedback</button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const stars = document.querySelectorAll('#star-rating .star');
        const ratingInput = document.getElementById('rating');

        stars.forEach(star => {
            star.addEventListener('click', function () {
                const ratingValue = this.getAttribute('data-value');
                ratingInput.value = ratingValue; // Met à jour le champ caché avec la note sélectionnée

                // Met à jour l'affichage des étoiles
                stars.forEach(s => s.classList.remove('text-warning')); // Enlève la couleur des étoiles
                for (let i = 0; i < ratingValue; i++) {
                    stars[i].classList.add('text-warning'); // Change la couleur des étoiles sélectionnées
                }
            });
        });
    });

    function validateForm() {
        const ratingValue = document.getElementById('rating').value;
        if (ratingValue === "0" || ratingValue === "") {
            alert("Veuillez sélectionner une note !");
            return false; // Empêche la soumission du formulaire
        }
        return true; // Permet la soumission du formulaire
    }
</script>
@endsection
