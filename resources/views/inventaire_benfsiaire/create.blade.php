@extends('layouts.app')

@section('content')
<div class="container-fluid p-4 mb-5 wow fadeIn" data-wow-delay="0.1s" style="margin-top: 100px;">
    <div class="container">
        <h2 class="mb-4 text-center">Ajouter un produit dans l'inventaire</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('inventaires-beneficiaires.store') }}" method="POST">
            @csrf

            <div class="row">
                @foreach($produits as $produit)
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $produit->nom }}</h5>
                                <p class="card-text">Stock: {{ $produit->quantite }}</p>
                                <input type="checkbox" class="produit-checkbox" id="checkbox_{{ $produit->id }}" name="produits[]" value="{{ $produit->id }}" onchange="toggleQuantityInput(this, '{{ $produit->id }}')">
                                <label for="checkbox_{{ $produit->id }}">Sélectionner</label>
                                <div class="quantity-input" id="quantity-input-{{ $produit->id }}" style="display: none;">
                                    <label for="quantite_{{ $produit->id }}">Quantité:</label>
                                    <input type="number" name="quantite[{{ $produit->id }}]" id="quantite_{{ $produit->id }}" class="form-control" min="1" onfocus="this.removeAttribute('required');" onblur="if(this.value == '') this.setAttribute('required', 'required');">
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <button type="submit" class="btn btn-primary">Ajouter à l'inventaire</button>
        </form>
    </div>
</div>

<script>
function toggleQuantityInput(checkbox, productId) {
    var quantityInput = document.getElementById('quantity-input-' + productId);
    if (checkbox.checked) {
        quantityInput.style.display = 'block'; // Afficher le champ de quantité
        document.getElementById('quantite_' + productId).setAttribute('required', 'required'); // Ajouter 'required'
    } else {
        quantityInput.style.display = 'none'; // Masquer le champ de quantité
        document.getElementById('quantite_' + productId).value = ''; // Réinitialiser la valeur
        document.getElementById('quantite_' + productId).removeAttribute('required'); // Retirer 'required'
    }
}
</script>
@endsection
