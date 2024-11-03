<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProduitAlimentaire;
use Illuminate\Http\Request;

class ProduitAdminController extends Controller
{
    // Affichage des produits avec pagination
   // Exemple d'une méthode dans votre contrôleur
public function index()
{
    $produits = ProduitAlimentaire::paginate(10); // Votre logique de pagination ici
    $totalProduits = ProduitAlimentaire::count();
    $produitsApprouves = ProduitAlimentaire::where('approuve', true)->count();
    $produitsRejetes = ProduitAlimentaire::where('rejeté', true)->count();
    $produitsEnAttente = $totalProduits - $produitsApprouves - $produitsRejetes;

    return view('admin.produits.index', compact('produits', 'totalProduits', 'produitsApprouves', 'produitsRejetes', 'produitsEnAttente'));
}

    

    // Approuver un produit spécifique
    public function approuver($id)
    {
        $produit = ProduitAlimentaire::findOrFail($id);
        $produit->approuve = true; // Marquer comme approuvé
        $produit->save();

        return redirect()->back()->with('success', 'Produit approuvé avec succès.');
    }
    public function rejeter($id)
{
    $produit = ProduitAlimentaire::findOrFail($id);
    $produit->approuve = false; // Assurez-vous de définir l'état approuvé sur false
    $produit->rejeté = true; // Définir l'état rejeté sur true
    $produit->save();

    return redirect()->back()->with('success', 'Produit rejeté avec succès.');
}

}
