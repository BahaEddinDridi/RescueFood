@extends('layouts.app')

@section('content')
<div class="container-fluid p-4 mb-5 wow fadeIn" data-wow-delay="0.1s" style="margin-top: 100px">
    <h1>Liste des événements</h1>
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('events.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Ajouter un nouvel événement
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Lieu</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($events as $event)
                    <tr>
                        <td>{{ $event->name }}</td>
                        <td>{{ $event->description }}</td>
                        <td>{{ $event->date }}</td>
                        <td>{{ $event->location }}</td>
                        <td>
                            <a href="{{ route('events.edit', $event->id) }}" class="btn btn-sm btn-info mb-2">
                                <i class="fas fa-edit"></i> Modifier
                            </a>
                            <a href="{{ route('events.show', $event->id) }}" class="btn btn-sm btn-secondary mb-2">
                                <i class="fas fa-magic"></i> Generate Description
                            </a>
                            <form action="{{ route('events.destroy', $event->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet événement ?');">
                                    <i class="fas fa-trash"></i> Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
