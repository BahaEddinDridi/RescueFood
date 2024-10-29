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
        $produits = ProduitAlimentaire::paginate(10);
        return view('admin.produits.index', compact('produits'));
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
