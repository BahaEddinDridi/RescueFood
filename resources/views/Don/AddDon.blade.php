@extends('layouts.app')


@section('content')

<div class="container-fluid p-4 mb-5 wow fadeIn" data-wow-delay="0.1s" style="margin-top: 100px;">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4 text-center">Ajouter un don</h2>
        </div>
    </div>
    <form action="{{ route('Dons.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group mb-3">
        <label for="typeAliment">Type de l'aliment</label>
        <input type="text" name="type_aliment" id="typeAliment" class="form-control" placeholder="Entrer le type de l'aliment" >
        @error('type_aliment')
                <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="quantite">Quantité</label>
        <input type="number" name="quantité" id="quantite" class="form-control" placeholder="Entrer la quantité" >
        @error('quantité')
                <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="deadline">Date de préremption</label>
        <input type="date" name="date_peremption" id="deadline" class="form-control" >
        @error('date_peremption')
                <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="dateDon">Date du don</label>
        <input type="date" name="date_don" id="dateDon" class="form-control">
        @error('date_don')
                <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="statut">Statut</label>
        <select name="statut" id="statut" class="form-control">
            <option value="disponible">Disponible</option>
            <option value="récupéré">Récupéré</option>
        </select>
        @error('statut')
                <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary btn-block">Ajouter</button>
</form>
</div>

@endsection
