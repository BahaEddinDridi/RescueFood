@extends('layouts.app')

@section('title', 'Add Reservation')

@section('content')
<div class="container-fluid p-4 mb-5 wow fadeIn" data-wow-delay="0.1s" style="margin-top: 100px;">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4 text-center">Ajouter une Réservation</h2>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Formulaire d'ajout de réservation -->
    <form action="{{ route('reservations.store') }}" method="POST" @if ($errors->has('no_dons')) style="pointer-events: none; opacity: 0.5;" @endif>
        @csrf <!-- Protection CSRF de Laravel -->

        <!-- Type d'Aliment -->
        <div class="form-group mb-3">
            <label for="type_aliment">Type d'Aliment</label>
            <select name="type_aliment" id="type_aliment" class="form-control" required>
                <option value="">Sélectionnez un type d'aliment</option>
                @foreach ($donsDisponibles as $don)
                    <option value="{{ $don->type_aliment }}">{{ $don->type_aliment }}</option>
                @endforeach
            </select>
        </div>

        <!-- Date de Réservation -->
        <div class="form-group mb-3">
            <label for="date_reservation">Date de Réservation</label>
            <input type="date" name="date_reservation" id="date_reservation" class="form-control" value="{{ now()->format('Y-m-d') }}" required>
        </div>


          <div class="d-flex justify-content-between mt-4">
                <!-- Bouton Retour à la Liste -->
                <a href="{{ route('reservations.index') }}" class="btn btn-primary">Retour à la Liste</a>
                <!-- Bouton Mettre à jour -->
                <button type="submit" class="btn btn-success">Ajouter la Réservation</button>
            </div>
    </form>
</div>
@endsection
