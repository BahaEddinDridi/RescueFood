@extends('layouts.app')

@section('content')
<div class="p-4 mb-5" data-wow-delay="0.1s" style="margin-top: 100px;">
    <h1 class="text-center">Modifier le produit</h1>
    <div class="row justify-content-center">
    <div class="col-md-8">
    <form action="{{ route('produitAlimentaire.update', $produitAlimentaire->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nom">Nom :</label>
            <input type="text" name="nom" id="nom" class="form-control" placeholder="Entrez le nom de l'aliment" value="{{ old('nom', $produitAlimentaire->nom) }}">
            @error('nom')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="type">Type :</label>
            <select name="type" id="type" class="form-control">
                <option value="">Sélectionnez un type</option>
                <option value="alimentaire" {{ old('type', $produitAlimentaire->type) == 'alimentaire' ? 'selected' : '' }}>Alimentaire</option>
                <option value="frais" {{ old('type', $produitAlimentaire->type) == 'frais' ? 'selected' : '' }}>Frais</option>
            </select>
            @error('type')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group" id="categorie-group" style="{{ $produitAlimentaire->type == 'frais' ? 'display: block;' : 'display: none;' }}">
            <label for="categorie">Catégorie :</label>
            <select name="categorie" id="categorie" class="form-control">
                <option value="">Sélectionnez une catégorie</option>
                <option value="fruit" {{ old('categorie', $produitAlimentaire->categorie) == 'fruit' ? 'selected' : '' }}>Fruit</option>
                <option value="legume" {{ old('categorie', $produitAlimentaire->categorie) == 'legume' ? 'selected' : '' }}>Légume</option>
            </select>
            @error('categorie')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="quantite">Quantité :</label>
            <input type="number" name="quantite" id="quantite" class="form-control" placeholder="Entrez la quantité" value="{{ old('quantite', $produitAlimentaire->quantite) }}">
            @error('quantite')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="date_peremption">Date de péremption :</label>
            <input type="date" name="date_peremption" id="date_peremption" class="form-control" value="{{ old('date_peremption', $produitAlimentaire->date_peremption) }}">
            @error('date_peremption')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="image_url">Image :</label>
            <input type="file" name="image_url" id="image_url" class="form-control" accept="image/*">
            @if($produitAlimentaire->image_url)
                <div class="mt-2">
                    <img src="{{ asset($produitAlimentaire->image_url) }}" alt="{{ $produitAlimentaire->nom }}" class="img-fluid" id="image-preview">
                </div>
            @endif
        </div>
        
        <button type="submit" class="btn btn-outline-primary border-2 py-2 px-4 mt-3 rounded-pill">Mettre à jour le produit</button>
    </form>
</div></div>
    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const typeSelect = document.getElementById('type');
        const categorieGroup = document.getElementById('categorie-group');

        typeSelect.addEventListener('change', function() {
            if (this.value === 'frais') {
                categorieGroup.style.display = 'block';
            } else {
                categorieGroup.style.display = 'none'; 
                document.getElementById('categorie').value = ''; // Reset category selection
            }
        });

        // Preview the selected image
        const imageInput = document.getElementById('image_url');
        const imagePreview = document.getElementById('image-preview');

        imageInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result; // Set the preview image source
                    imagePreview.classList.add('mt-2', 'img-fluid'); // Add classes for styling
                    imagePreview.style.display = 'block'; // Ensure the image is displayed
                };
                reader.readAsDataURL(file);
            } else {
                imagePreview.src = ''; // Clear the image if no file is selected
                imagePreview.style.display = 'none'; // Hide the image
            }
        });
    });
</script>
@endsection
