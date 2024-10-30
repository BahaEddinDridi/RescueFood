<?php

namespace App\Http\Controllers;

use App\Models\ProduitAlimentaire;
use Illuminate\Http\Request;

class ProduitAlimentaireController extends Controller
{
    /**
     * Display the user's products.
     *
     * @return \Illuminate\Http\Response
     */
    public function mesProduits()
    {
        // Récupère uniquement les produits approuvés de l'utilisateur connecté
        $produitAlimentaire = ProduitAlimentaire::where('user_id', auth()->id())
            ->where('approuve', true) // Filtrer par produits approuvés
            ->get();
    
        return view('produitAlimentaire.mesProduits', compact('produitAlimentaire'));
    }
    

    /**
     * Display a listing of approved products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Récupérer le terme de recherche depuis la requête
        $query = $request->input('search');
    
        // Filtrer les produits approuvés, avec option de recherche
        $produitAlimentaire = ProduitAlimentaire::where('approuve', true)
            ->when($query, function ($queryBuilder) use ($query) {
                return $queryBuilder->where('nom', 'like', '%' . $query . '%');
            })
            ->get();
    
        return view('produitAlimentaire.index', compact('produitAlimentaire'));
    }
    

    /**
     * Show the form for creating a new product.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('produitAlimentaire.create');
    }

    /**
     * Store a newly created product in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'categorie' => 'nullable|string|max:255',
            'quantite' => 'required|integer',
            'date_peremption' => 'required|date|after_or_equal:today',
            'type' => 'required|string|max:255',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Create new product
        $produit = new ProduitAlimentaire();
        $produit->user_id = auth()->id(); // Set the user_id to the currently authenticated user's ID
        $produit->nom = $request->nom;
        $produit->categorie = $request->categorie;
        $produit->quantite = $request->quantite;
        $produit->date_peremption = $request->date_peremption;
        $produit->type = $request->type;

        // Handle the image upload if it exists
        if ($request->hasFile('image_url')) {
            $image = $request->file('image_url');
            $imageName = time() . '.' . $image->getClientOriginalExtension(); // Generate a unique filename
            $imagePath = $image->storeAs('public/img', $imageName); // Store the image in 'public/img' directory
            $produit->image_url = str_replace('public/', 'storage/', $imagePath); // Update the image_url to use the 'storage/' path
        }

        $produit->save();

        return redirect()->route('produitAlimentaire.mesProduits')->with('waiting_for_approval', 'Produit ajouté avec succès. Veuillez attendre l\'approbation de l\'administrateur.');
    }

    /**
     * Display the specified product.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produitAlimentaire = ProduitAlimentaire::findOrFail($id);
        return view('produitAlimentaire.show', compact('produitAlimentaire'));
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $produitAlimentaire = ProduitAlimentaire::findOrFail($id);
        return view('produitAlimentaire.edit', compact('produitAlimentaire'));
    }

    /**
     * Update the specified product in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'categorie' => ['nullable', 'string', 'max:255'], 
            'quantite' => ['required', 'integer'],
            'date_peremption' => 'required|date|after:today',
            'type' => ['required', 'string'],
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $produitAlimentaire = ProduitAlimentaire::findOrFail($id);

        // Handle image upload
        $imagePath = $produitAlimentaire->image_url; 
        if ($request->hasFile('image_url')) {
            $image = $request->file('image_url');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('public/images', $imageName);
            $imagePath = str_replace('public/', 'storage/', $imagePath);
        }

        $produitAlimentaire->update([
            'nom' => $request->input('nom'),
            'categorie' => $request->input('categorie'), // This can be null
            'quantite' => $request->input('quantite'),
            'date_peremption' => $request->input('date_peremption'),
            'type' => $request->input('type'),
            'image_url' => $imagePath,
        ]);

        return redirect()->route('produitAlimentaire.mesProduits')->with('success', 'Produit mis à jour avec succès');
    }

    /**
     * Remove the specified product from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produitAlimentaire = ProduitAlimentaire::findOrFail($id);
        $produitAlimentaire->delete();
        return redirect()->route('produitAlimentaire.mesProduits')->with('success', 'Produit supprimé avec succès');
    }
}
