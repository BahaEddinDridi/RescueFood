<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InventaireDonateur; // Corrigé ici
use App\Models\ProduitAlimentaire;
use Illuminate\Support\Facades\Auth;

class InventaireDonateurController extends Controller
{
    public function index() {
        $invDonateur = InventaireDonateur::all(); // Corrigé ici
        $userId = Auth::id();
        
        return view('InventaireDonateur.View', compact('invDonateur', 'userId'));
    }

    public function create($userId)
    {
        return view('InventaireDonateur.AddInventaireDonateur', compact('userId'));
    }

    public function store(Request $request)
{
    $request->validate([
        'select_produit' => 'required|array',
        'select_produit.*' => 'exists:produits_alimentaires,id',
    ]);

    $userId = Auth::id(); // Obtenez l'ID de l'utilisateur connecté

    foreach ($request->select_produit as $produitId) {
        $produit = ProduitAlimentaire::find($produitId);

        if ($produit) {
            InventaireDonateur::create([
                'nom_article' => $produit->nom,
                'quantité' => $produit->quantite,
                'date_peremption' => $produit->date_peremption,
                'localisation' => 'Localisation par défaut',
                'user_id' => $userId, // Ajoutez l'ID de l'utilisateur ici
            ]);
        }
    }

    return redirect()->route('invertaireDonateurs.index')->with('success', 'Produits ajoutés à l\'inventaire avec succès.');
}

    public function show($id, $userId)
    {
        $invDonateur = InventaireDonateur::find($id);
        if (!$invDonateur) {
            return redirect()->route('invertaireDonateurs.index', ['userId' => $userId])
                             ->with('error', 'Article non trouvé.');
        }
    
        return view('InventaireDonateur.showInventaireDonateur', compact('invDonateur', 'userId'));
    }
    
    
    public function edit($id, $userId)
    {
        $invDonateur = InventaireDonateur::find($id);
        if (!$invDonateur) {
            return redirect()->route('invertaireDonateurs.index', ['userId' => $userId])
                             ->with('error', 'Article non trouvé.');
        }
        return view('InventaireDonateur.Edit', compact('invDonateur', 'userId'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nom_article' => 'required|string|max:255',
            'quantité' => 'required|integer|min:1',
            'date_peremption' => 'required|date',
            'localisation' => 'required|string|max:255',
        ]);

        $invDonateur = InventaireDonateur::find($id);
        if ($invDonateur) {
            $invDonateur->update($request->all());
            return redirect()->route('invertaireDonateurs.index')->with('success', 'Article mis à jour avec succès.');
        }

        return redirect()->route('invertaireDonateurs.index')->with('error', 'Article non trouvé.');
    }

    public function destroy($id)
    {
        $invDonateur = InventaireDonateur::find($id);
        if ($invDonateur) {
            $invDonateur->delete();
            return redirect()->route('invertaireDonateurs.index')->with('success', 'Article supprimé avec succès.');
        }

        return redirect()->route('invertaireDonateurs.index')->with('error', 'Article non trouvé.');
    }

    public function getProduitsAlimentaires($userId)
{
    $produitsAlimentaires = ProduitAlimentaire::where('user_id', $userId)->paginate(6); // Pagination
    return view('InventaireDonateur.AddInventaireDonateur', compact('produitsAlimentaires', 'userId'));
}


public function addSelectedProduits(Request $request)
{
    $userId = Auth::id(); // Obtenez l'ID de l'utilisateur connecté

    $request->validate([
        'produits' => 'required|array',
        'produits.*' => 'exists:produits_alimentaires,id',
    ]);

    foreach ($request->produits as $produitId) {
        $produit = ProduitAlimentaire::find($produitId);

        if ($produit) {
            InventaireDonateur::create([
                'nom_article' => $produit->nom,
                'quantité' => $produit->quantite,
                'date_peremption' => $produit->date_peremption,
                'localisation' => 'Localisation par défaut',
                'user_id' => $userId, // Ajoutez l'ID de l'utilisateur ici
            ]);
        }
    }

    return redirect()->route('invertaireDonateurs.index', ['userId' => $userId])
                     ->with('success', 'Produits ajoutés à l\'inventaire avec succès.');
}

}
