@extends('layouts.app')

@section('content')
<div class="container-fluid p-4 mb-5 wow fadeIn" data-wow-delay="0.1s" style="margin-top: 100px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4 text-center">Modifier la Réservation</h2>
            </div>
        </div>
        
        

        <form action="{{ route('reservations.update', $reservation->id) }}" method="POST">
            @csrf
            @method('PUT') <!-- Méthode PUT pour la mise à jour -->
            
            <!-- Type d'Aliment -->
            <div class="form-group mb-3">
                <label for="type_aliment">Type d'Aliment</label>
                <select name="type_aliment" id="type_aliment" class="form-control" >
                    <option value="">Sélectionnez un type d'aliment</option>
                    @foreach ($donsDisponibles as $don)
                        <option value="{{ $don->type_aliment }}" {{ $reservation->don->type_aliment == $don->type_aliment ? 'selected' : '' }}>
                            {{ $don->type_aliment }}
                        </option>
                    @endforeach
                </select>
                @error('type_aliment')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Date de Réservation -->
            <div class="form-group mb-3">
                <label for="date_reservation">Date de Réservation</label>
                <input type="date" name="date_reservation" id="date_reservation" class="form-control" 
                    value="{{ $reservation->date_reservation ? $reservation->date_reservation->format('Y-m-d') : '' }}" >
                @error('date_reservation')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

           

            <div class="d-flex justify-content-between mt-4">
                <!-- Bouton Mettre à jour -->
                <button type="submit" class="btn btn-success">Mettre à jour la Réservation</button>
                <!-- Bouton Retour à la Liste -->
                <a href="{{ route('reservations.index') }}" class="btn btn-primary">Retour à la Liste</a>
                
            </div>
        </form>
    </div>
</div>
@endsection
