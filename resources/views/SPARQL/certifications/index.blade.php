<!-- resources/views/sparql/certifications/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des Certifications</h1>
        <!-- Button to add a new certification -->
        <a href="{{ route('certificats.create') }}" class="btn btn-primary mb-3">Ajouter une Certification</a>
    <table class="table">
        <thead>
            <tr>
                <th>URI</th>
                <th>Label</th>
                <th>Description</th>
                <th>Date de Création</th>
                <th>Date de Validité</th>
            </tr>
        </thead>
        <tbody>
            @foreach($certifications as $certification)
                <tr>
                    <td>{{ $certification['uri'] }}</td>
                    <td>{{ $certification['label'] }}</td>
                    <td>{{ $certification['description'] }}</td>
                    <td>{{ $certification['date_creation'] }}</td>
                    <td>{{ $certification['date_validite'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
