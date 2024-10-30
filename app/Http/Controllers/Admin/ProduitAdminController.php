<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProduitAlimentaire;
use Illuminate\Http\Request;

class ProduitAdminController extends Controller
{
    // Affichage des produits avec pagination
    public function index()
    {
        // Récupérer les produits avec pagination
        $produits = ProduitAlimentaire::paginate(10);
    
        // Statistiques
        $totalProduits = ProduitAlimentaire::count();
        $produitsApprouves = ProduitAlimentaire::where('approuve', true)->count();
        $produitsEnAttente = ProduitAlimentaire::where('approuve', false)->count();
       
    
        return view('admin.produits.index', compact('produits', 'totalProduits', 'produitsApprouves', 'produitsEnAttente'));
    }
    

    // Approuver un produit spécifique
    public function approuver($id)
    {
        $produit = ProduitAlimentaire::findOrFail($id);
        $produit->approuve = true; // Marquer comme approuvé
        $produit->save();

        return redirect()->back()->with('success', 'Produit approuvé avec succès.');
    }
}
