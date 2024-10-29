@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="card flex-fill">
        <table class="table table-hover my-0">
            <thead>
                <tr>
                    <th>Nom du Produit</th>
                    <th class="d-none d-xl-table-cell">Catégorie</th>
                    <th class="d-none d-xl-table-cell">Quantité</th>
                    <th class="d-none d-xl-table-cell">Date de Péremption</th>
                    <th class="d-none d-xl-table-cell">Type</th>
                    <th class="d-none d-md-table-cell">Image</th>
                    <th class="d-none d-md-table-cell">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($produits as $produit)
                    <tr>
                        <td>{{ $produit->nom }}</td>
                        <td class="d-none d-xl-table-cell">{{ $produit->categorie }}</td>
                        <td class="d-none d-xl-table-cell">{{ $produit->quantite }}</td>
                        <td class="d-none d-xl-table-cell">
                            {{ \Carbon\Carbon::parse($produit->date_peremption)->format('d/m/Y') }}
                        </td>
                        <td class="d-none d-xl-table-cell">{{ $produit->type }}</td>
                        <td class="d-none d-md-table-cell">
                            <img src="{{ asset($produit->image_url) }}" alt="{{ $produit->nom }}" 
                                 style="width: 50px; height: 50px; object-fit: cover;">
                        </td>
                        <td>
                            @if($produit->approuve)
                                <span class="text-success">Approuvé</span>
                               
                            @else
                                <form action="{{ route('admin.produitAlimentaire.approuver', $produit->id) }}" method="POST" style="display: inline;" onsubmit="return confirmApproval();">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-approve">Approuver</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    function confirmApproval() {
        return confirm("Êtes-vous sûr de vouloir approuver ce produit ?");
    }
</script>
@endsection
