@extends('layouts.app')

@section('content')
   <div class="container-fluid p-4 mb-5 wow fadeIn" data-wow-delay="0.1s" style="margin-top: 100px">
       <h1>Modifier la Certification</h1>

       <form action="{{ route('certifications.update', $certification->id) }}" method="POST">
           @csrf
           @method('PUT')

           <div class="form-group">
               <label for="nom">Nom</label>
               <input type="text" class="form-control" id="nom" name="nom" value="{{ $certification->nom }}" required>
           </div>

           <div class="form-group">
               <label for="description">Description</label>
               <textarea class="form-control" id="description" name="description" rows="3">{{ $certification->description }}</textarea>
           </div>

           <div class="form-group">
               <label for="date_validation">Date de Validation</label>
               @php
                   // Attempt to parse the date only if it's a string
                   $dateValidation = is_string($certification->date_validation) 
                       ? \Carbon\Carbon::parse($certification->date_validation) 
                       : $certification->date_validation;
               @endphp
               <input type="date" class="form-control" id="date_validation" name="date_validation" value="{{ $dateValidation instanceof \Carbon\Carbon ? $dateValidation->format('Y-m-d') : '' }}" required>
           </div>

           <div class="form-group">
               <label for="statut">Statut</label>
               <select class="form-control" id="statut" name="statut" required>
                   <option value="" disabled>Select Statut</option>
                   <option value="active" {{ $certification->statut === 'active' ? 'selected' : '' }}>Active</option>
                   <option value="inactive" {{ $certification->statut === 'inactive' ? 'selected' : '' }}>Inactive</option>
                   <option value="pending" {{ $certification->statut === 'pending' ? 'selected' : '' }}>Pending</option>
                   <option value="expired" {{ $certification->statut === 'expired' ? 'selected' : '' }}>Expired</option>
                   <!-- Add more options as needed -->
               </select>
           </div>

           <button type="submit" class="btn btn-success">Mettre à jour</button>
           <a href="{{ route('certifications.index') }}" class="btn btn-secondary">Retour</a>
       </form>
   </div>
@endsection
