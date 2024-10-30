@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="card flex-fill">
        <div class="card-header">
            <h4>Produits Alimentaires</h4>
        </div>
        <div class="statistics">
            <div class="stat-circle">
                <div class="circle total">{{ $totalProduits }}</div>
                <strong>Total Produits</strong>
            </div>
            <div class="stat-circle">
                <div class="circle approved">{{ $produitsApprouves }}</div>
                <strong>Approuvés</strong>
            </div>
            <div class="stat-circle">
                <div class="circle pending">{{ $produitsEnAttente }}</div>
                <strong>En Attente</strong>
            </div>
        </div>

        <table class="table table-hover my-0">
            <thead>
                <tr>
                    <th>Nom du Produit</th>
                    <th class="d-none d-xl-table-cell">Catégorie</th>
                    <th class="d-none d-xl-table-cell">Quantité</th>
                    <th class="d-none d-xl-table-cell">Date de Péremption</th>
                    <th class="d-none d-xl-table-cell">Type</th>
                    <th class="d-none d-md-table-cell">Image</th>
                    <th class="d-none d-md-table-cell">Statut</th>
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
                        <td class="d-none d-md-table-cell">
                            @if($produit->approuve)
                                <span class="text-success">Approuvé</span>
                            @else
                                <span class="text-warning">En Attente</span>
                            @endif
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
        
        <!-- Pagination -->
        <div class="card-footer">
            {{ $produits->links() }} <!-- Ajoute la pagination -->
        </div>
    </div>
</div>

<script>
    function confirmApproval() {
        return confirm("Êtes-vous sûr de vouloir approuver ce produit ?");
    }

    function confirmRejection() {
        return confirm("Êtes-vous sûr de vouloir rejeter ce produit ?");
    }
</script>

<style>
    .statistics {
        display: flex;
        justify-content: space-around;
        margin: 20px 0;
    }

    .stat-circle {
        text-align: center;
    }

    .circle {
        display: inline-block;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        line-height: 60px;
        font-size: 1.2em;
        font-weight: bold;
        color: white;
        margin-bottom: 5px;
    }

    .total {
        background-color: #007bff; /* Couleur pour total */
    }

    .approved {
        background-color: #28a745; /* Couleur pour approuvés */
    }

    .pending {
        background-color: #ffc107; /* Couleur pour en attente */
    }
</style>
@endsection
