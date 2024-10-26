@extends('layouts.app')

@section('content')
   <div class="container-fluid p-4 mb-5 wow fadeIn" data-wow-delay="0.1s" style="margin-top: 100px">
       <h1>Liste des Certifications</h1>
       
       <div class="d-flex justify-content-end mb-3">
           <a href="{{ route('certifications.create') }}" class="btn btn-primary">
               <i class="fas fa-plus"></i> Ajouter une nouvelle certification
           </a>
       </div>

       <div class="row">
           @foreach($certifications as $certification)
               <div class="col-md-4 mb-4">
                   <div class="card h-100 shadow-sm">
                       <div class="card-body">
                           <h5 class="card-title">{{ $certification->nom }}</h5>
                           <p class="card-text">{{ Str::limit($certification->description, 100) }}</p>
                           <p class="text-muted">Date de validation: {{ \Carbon\Carbon::parse($certification->date_validation)->format('d M Y') }}</p>
                           <p class="text-muted">Statut: {{ $certification->statut }}</p>
                       </div>
                       
                       <div class="card-footer d-flex justify-content-between">
                           <a href="{{ route('certifications.edit', $certification->id) }}" class="btn btn-info btn-sm">
                               <i class="fas fa-edit"></i> Modifier
                           </a>
                           <form action="{{ route('certifications.destroy', $certification->id) }}" method="POST" style="display:inline-block;">
                               @csrf
                               @method('DELETE')
                               <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette certification ?');">
                                   <i class="fas fa-trash"></i> Supprimer
                               </button>
                           </form>
                       </div>
                   </div>
               </div>
           @endforeach

           @if($certifications->isEmpty())
           <div class="col-12">
               <div class="alert alert-info">
                   Aucune certification disponible.
               </div>
           </div>
           @endif
       </div>
   </div>
@endsection
