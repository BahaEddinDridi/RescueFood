@extends('layouts.app')

@section('content')
<div class="container mt-5 mb-5">
    <div class="card border-0 shadow-lg" style="max-width: 900px; margin: auto; border: 2px solid #D4AF37; border-radius: 15px; background-color: #fffdf5; position: relative; overflow: hidden;">
        <!-- Background Logo -->
        <div class="background-logo" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; z-index: 1; opacity: 0.08; display: flex; justify-content: center; align-items: center;">
            <h1 class="fw-bold text-primary m-0" style="font-size: 150px;">Res<span class="text-secondary">cueF</span>ood</h1>
        </div>

        <div class="card-body text-center" style="padding: 80px 60px; position: relative; z-index: 2;">
            <h1 class="display-4 mb-4" style="color: #333; font-weight: bold;">Certificat de Produit</h1>
            <i class="fas fa-award fa-4x text-warning mb-4"></i> <!-- Badge Icon -->
            <hr class="my-4" style="border-top: 3px solid #D4AF37; width: 60%; margin: auto;">
            
            <h3 class="font-weight-bold mt-4" style="color: #D4AF37; font-size: 1.75em;">{{ $certification->nom }}</h3>
            <p class="lead mb-4" style="color: #555; font-size: 1.15em;">Description : {{ $certification->description }}</p>
            
            <div class="mb-4">
                <p style="font-weight: 500; font-size: 1.1em;">Date de validation : <strong>{{ \Carbon\Carbon::parse($certification->date_validation)->format('d M Y') }}</strong></p>
                <p style="font-weight: 500; font-size: 1.1em;">Statut : <span class="badge rounded-pill" style="background-color: #FFD700; color: #333; padding: 0.5em 1em; font-size: 1em;">{{ ucfirst($certification->statut) }}</span></p>
            </div>
        </div>

        <!-- Signature section -->
        <div class="text-end" style="padding: 20px 40px;">
            <div style="padding: 10px; border-radius: 5px; display: inline-block; border-top: 2px solid #D4AF37;">
                
                <img src="{{ asset('img/fake_signature.png') }}" alt="Signature" style="width: 180px; height: auto;">
            </div>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('certifications.download', $certification->id) }}" class="btn btn-outline-success rounded-pill">
            <i class="fas fa-download"></i> Télécharger PDF
        </a>
        <a href="{{ route('produitAlimentaire.index') }}" class="btn btn-outline-secondary rounded-pill" style="margin-top: 10px;">
            Retour à la liste
        </a>
    </div>
</div>
@endsection
