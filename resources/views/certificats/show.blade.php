@extends('layouts.app')

@section('content')
<div class="container mt-5 mb-5">
    <div class="card border-0 shadow" style="max-width: 800px; margin: auto; border: 2px solid #D4AF37; border-radius: 10px; background-color: #f9f9f9; position: relative; overflow: hidden;">
        <!-- Background Logo -->
        <div class="background-logo" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; z-index: 1; opacity: 0.1; display: flex; justify-content: center; align-items: center;">
            <h1 class="fw-bold text-primary m-0" style="font-size: 100px;">Res<span class="text-secondary">cueF</span>ood</h1>
        </div>

        <div class="card-body text-center" style="padding: 60px 40px; position: relative; z-index: 2;">
            <h1 class="display-4 mb-4" style="color: #333; font-weight: bold;">Certificat de Produit</h1>
            <i class="fas fa-award fa-3x text-warning mb-4"></i> <!-- Badge Icon -->
            <hr class="my-4" style="border-top: 2px solid #D4AF37; width: 50%; margin: auto;">
            
            <h3 class="font-weight-bold" style="color: #007bff;">{{ $certification->nom }}</h3>
            <p class="lead mb-4" style="color: #555; font-size: 1.2em;">Description : {{ $certification->description }}</p>
            
            <div class="mb-4">
                <p style="font-weight: 500;">Date de validation : <strong>{{ \Carbon\Carbon::parse($certification->date_validation)->format('d M Y') }}</strong></p>
                <p style="font-weight: 500;">Statut : <span class="badge" style="background-color: gold; color: black;">{{ ucfirst($certification->statut) }}</span></p>
            </div>
        </div>

        <div class="text-left" style="padding: 20px;">
            <div style="padding: 10px; border-radius: 5px; display: inline-block;">
                <p class="font-italic mb-1 ">Signature :</p>
                <img src="{{ asset('img/fake_signature.png') }}" alt="Signature" style="width: 150px; height: auto;">
            </div>
        </div>

      
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('certifications.index') }}" class="btn btn-outline-secondary rounded-pill">Retour à la liste</a>
    </div>
</div>
@endsection
