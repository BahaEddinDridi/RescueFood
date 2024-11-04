<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InventaireBeneficiaire;
use App\Models\ProduitAlimentaire;
use Illuminate\Support\Facades\Auth;
class InventaireBeneficiaireController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $localisation = InventaireBeneficiaire::query()->value('localisation');
        $inventaires = InventaireBeneficiaire::all(); // Récupérer tous les articles dans l'inventaire des bénéficiaires
        $produitsDisponibles = ProduitAlimentaire::all(); // Récupérer tous les produits disponibles
        return view('inventaire_benfsiaire.index', compact( 'localisation','inventaires','produitsDisponibles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $produits = ProduitAlimentaire::all();
        return view('inventaire_benfsiaire.create', compact('produits'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'produits' => 'required|array',
            'produits.*' => 'exists:produits_alimentaires,id',
            'quantite' => 'required|array',
            'quantite.*' => 'required_with:produits.*|integer|min:1', // Validation ici
        ], [
            'produits.required' => 'Veuillez sélectionner au moins un produit.',
            'produits.*.exists' => 'Un ou plusieurs produits sélectionnés n\'existent pas.',
            'quantite.required' => 'Veuillez spécifier une quantité pour chaque produit sélectionné.',
            'quantite.*.required_with' => 'La quantité est obligatoire pour les produits sélectionnés.',
            'quantite.*.integer' => 'La quantité doit être un entier.',
            'quantite.*.min' => 'La quantité doit être au moins 1.',
        ]);

    // Logique d'ajout de produits à l'inventaire
    foreach ($request->produits as $produitId) {
        // Vérifier si une quantité a été soumise pour le produit sélectionné
        if (!isset($request->quantite[$produitId])) {
            return redirect()->back()->with('error', 'Quantité manquante pour le produit ' . $produitId);
        }

        $quantiteDemandee = $request->quantite[$produitId];
        $produit = ProduitAlimentaire::find($produitId);

        if (!$produit) {
            return redirect()->back()->with('error', 'Produit non trouvé.');
        }

        // Vérification de la quantité disponible
        if ($produit->quantite < $quantiteDemandee) {
            return redirect()->back()->with('error', 'Quantité insuffisante pour le produit ' . $produit->nom . '.');
        }

        // Réduire la quantité du produit dans la table des produits
        $produit->quantite -= $quantiteDemandee;
        $produit->save();

        // Ajouter le produit dans l'inventaire du bénéficiaire
        InventaireBeneficiaire::create([
            'user_id' => Auth::id(), // utilisateur connecté
            'produit_id' => $produit->id,
            'quantite' => $quantiteDemandee,
            // 'localisation' => $request->localisation, // Ajoutez cela si nécessaire
        ]);
    }

    return redirect()->back()->with('success', 'Produits ajoutés avec succès à l\'inventaire.');

    }
        

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('inventaire_benfsiaire.show', compact('inventaireBeneficiaire'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $inventaireBeneficiaire = InventaireBeneficiaire::find($id);
        return view('inventaire_benfsiaire.edit', compact('inventaireBeneficiaire'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateLocalisation(Request $request)
    {
        // Validation de la localisation uniquement
        $request->validate([
            'localisation' => 'required|string',
        ]);
    
        // Mettre à jour le champ `localisation` pour tous les enregistrements
        InventaireBeneficiaire::query()->update(['localisation' => $request->localisation]);
    
        return redirect()->route('inventaires-beneficiaires.index')->with('success', 'Article mis à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        InventaireBeneficiaire::find($id)->delete(); 


        return redirect()->route('inventaires-beneficiaires.index')->with('success', 'Article supprimé avec succès');
    }
}
