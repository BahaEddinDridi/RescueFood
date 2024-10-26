@extends('layouts.app')

@section('content')
   <div class="container-fluid p-4 mb-5 wow fadeIn" data-wow-delay="0.1s" style="margin-top: 100px">
       <h1>Ajouter une Certification</h1>

       <form action="{{ route('certifications.store') }}" method="POST">
           @csrf
           <div class="form-group">
               <label for="nom">Nom</label>
               <input type="text" class="form-control" id="nom" name="nom" required>
           </div>

           <div class="form-group">
               <label for="description">Description</label>
               <textarea class="form-control" id="description" name="description" rows="3"></textarea>
           </div>

           <div class="form-group">
               <label for="date_validation">Date de Validation</label>
               <input type="date" class="form-control" id="date_validation" name="date_validation" required>
           </div>

           <div class="form-group">
               <label for="statut">Statut</label>
               <select class="form-control" id="statut" name="statut" required>
                   <option value="" disabled selected>Select Statut</option>
                   <option value="active">Active</option>
                   <option value="inactive">Inactive</option>
                   <option value="pending">Pending</option>
                   <option value="expired">Expired</option>
                   <!-- Add more options as needed -->
               </select>
           </div>

           <button type="submit" class="btn btn-success">Créer</button>
           <a href="{{ route('certifications.index') }}" class="btn btn-secondary">Retour</a>
       </form>
   </div>
@endsection
