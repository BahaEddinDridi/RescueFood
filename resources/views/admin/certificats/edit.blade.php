@extends('admin.layouts.app')

@section('content')
   <div class="container-fluid p-4 mb-5 wow fadeIn" data-wow-delay="0.1s" style="margin-top: 100px">
       <div class="row justify-content-center">
           <div class="col-md-8">
               <h1 class="text-center">Modifier la Certification</h1>

               <form action="{{ route('admin.certifications.update', $certification->id) }}" method="POST">
                   @csrf
                   @method('PUT')

                   <div class="form-group">
                       <label for="nom">Nom</label>
                       <input type="text" class="form-control" id="nom" name="nom" 
                              value="{{ old('nom', $certification->nom) }}" required>
                       @error('nom')
                           <div class="text-danger">{{ $message }}</div>
                       @enderror
                   </div>

                   <div class="form-group">
                       <label for="description">Description</label>
                       <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $certification->description) }}</textarea>
                       @error('description')
                           <div class="text-danger">{{ $message }}</div>
                       @enderror
                   </div>

                   <div class="form-group">
                       <label for="date_validation">Date de Validation</label>
                       @php
                           $dateValidation = is_string($certification->date_validation) 
                               ? \Carbon\Carbon::parse($certification->date_validation) 
                               : $certification->date_validation;
                       @endphp
                       <input type="date" class="form-control" id="date_validation" name="date_validation" 
                              value="{{ old('date_validation', $dateValidation instanceof \Carbon\Carbon ? $dateValidation->format('Y-m-d') : '') }}" 
                              required>
                       @error('date_validation')
                           <div class="text-danger">{{ $message }}</div>
                       @enderror
                   </div>

                   <div class="form-group">
                       <label for="statut">Statut</label>
                       <select class="form-control" id="statut" name="statut" required>
                           <option value="" disabled>-- Sélectionner le statut --</option>
                           <option value="active" {{ old('statut', $certification->statut) === 'active' ? 'selected' : '' }}>Active</option>
                           <option value="inactive" {{ old('statut', $certification->statut) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                           <option value="pending" {{ old('statut', $certification->statut) === 'pending' ? 'selected' : '' }}>Pending</option>
                           <option value="expired" {{ old('statut', $certification->statut) === 'expired' ? 'selected' : '' }}>Expired</option>
                       </select>
                       @error('statut')
                           <div class="text-danger">{{ $message }}</div>
                       @enderror
                   </div>

                   <div class="form-group mb-4">
                       <label for="produit_id">Produit Alimentaire</label>
                       <select class="form-control" id="produit_id" name="produit_id" required>
                           <option value="" disabled>-- Sélectionner un produit --</option>
                           @foreach($produits as $produit)
                               <option value="{{ $produit->id }}" 
                                   {{ old('produit_id', $certification->produit_id) == $produit->id ? 'selected' : '' }}>
                                   {{ $produit->nom }}
                               </option>
                           @endforeach
                       </select>
                       @error('produit_id')
                           <div class="text-danger">{{ $message }}</div>
                       @enderror
                   </div>

                   <button type="submit" class="btn btn-outline-primary border-2 py-2 px-4 mt-3 rounded-pill">Mettre à jour</button>
               </form>
           </div>
       </div>
   </div>
@endsection
