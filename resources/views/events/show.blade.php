<!-- event/show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container-fluid p-4 mb-5 wow fadeIn" data-wow-delay="0.1s" style="margin-top: 100px">
    <h1>Détails de l'événement</h1>
    
    <div class="mb-3">
        <a href="{{ route('events.index') }}" class="btn btn-primary">
            <i class="fas fa-arrow-left"></i> Retour à la liste des événements
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="card-title">{{ $event->name }}</h5>
        </div>
        <div class="card-body">
            <h6 class="card-subtitle mb-2 text-muted">Lieu: {{ $event->location }}</h6>
            <p class="card-text"><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->date)->format('d M, Y') }}</p>
            <p class="card-text"><strong>Description:</strong> {{ $event->description }}</p>

            @if(isset($generatedDescription))
                <div class="mt-3">
                    <h6><strong>Description générée:</strong></h6>
                    <p>{{ $generatedDescription }}</p>
                </div>
            @else
                <div class="mt-3">
                    <p><em>Aucune description générée</em></p>
                </div>
            @endif
        </div>

        <div class="card-footer text-muted d-flex justify-content-between">
            <div>
                <a href="{{ route('events.edit', $event->id) }}" class="btn btn-info btn-sm">
                    <i class="fas fa-edit"></i> Modifier
                </a>
                <form action="{{ route('events.destroy', $event->id) }}" method="POST" style="display:inline-block;" class="ml-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet événement ?');">
                        <i class="fas fa-trash"></i> Supprimer
                    </button>
                </form>
            </div>
            <div>
                <a href="{{ route('events.generateDescription', $event->id) }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-magic"></i> Générer une description
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
