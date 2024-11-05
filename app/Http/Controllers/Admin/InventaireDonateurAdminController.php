<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InventaireDonateur;

class InventaireDonateurAdminController extends Controller 
{
    // Affiche la liste des produits d'un utilisateur
    public function index($user_id)
    {
        $produits = InventaireDonateur::where('user_id', $user_id)->paginate(10); // Assurez-vous que 'user_id' existe dans votre table
        return view('admin.inventaireDonateur.index', compact('produits', 'user_id'));
    }

    // Affiche le formulaire d'édition pour un produit spécifique
    public function edit($id)
    {
        $produit = InventaireDonateur::findOrFail($id);
        return view('admin.inventaireDonateur.edit', compact('produit'));
    }

    // Met à jour un produit
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom_article' => 'required|string|max:255',
            'quantité' => 'required|integer|min:1',
            'date_peremption' => 'required|date',
            'localisation' => 'required|string|max:255',
        ]);

        $produit = InventaireDonateur::findOrFail($id);
        $produit->update($request->all());

        return redirect()->route('admin.inventaireDonateur.index', $produit->user_id)->with('success', 'Produit mis à jour avec succès');
    }

    // Supprime un produit
    public function destroy($id)
    {
        $produit = InventaireDonateur::findOrFail($id);
        $produit->delete();

        return redirect()->route('admin.inventaireDonateur.index', $produit->user_id)->with('success', 'Produit supprimé avec succès');
    }
}
