<?php

namespace App\Http\Controllers;

use App\Models\ProduitAlimentaire;
use App\Models\Certification;
use Illuminate\Http\Request;
use PDF; 

class CertificationController extends Controller
{
    // Affiche la liste des certifications
    public function index()
    {
        $certifications = Certification::with('produit')->get(); // Chargement de la relation 'produit'
        return view('certificats.index', compact('certifications'));
    }

    // Affiche le formulaire de création d'une certification
    public function create()
    {
        $produits = ProduitAlimentaire::all(); // Récupérer tous les produits
        return view('certificats.create', compact('produits'));
    }

    // Stocke une nouvelle certification dans la base de données
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_validation' => 'required|date',
            'statut' => 'required|string',
            'produit_id' => 'required|exists:produits_alimentaires,id', // Correction du nom de table
        ]);

        Certification::create($request->all());

        return redirect()->route('certifications.index')->with('success', 'Certification créée avec succès');
    }

    // Affiche le formulaire d'édition d'une certification
    public function edit(Certification $certification)
    {
        $produits = ProduitAlimentaire::all(); // Récupérer tous les produits
        return view('certificats.edit', compact('certification', 'produits'));
    }

    // Met à jour une certification existante
    public function update(Request $request, Certification $certification)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_validation' => 'required|date',
            'statut' => 'required|string',
            'produit_id' => 'required|exists:produits_alimentaires,id', // Validation de produit_id
        ]);

        $certification->update($request->all());

        return redirect()->route('certifications.index')->with('success', 'Certification mise à jour avec succès');
    }
    public function show($id)
    {
        $certification = Certification::findOrFail($id);
        return view('certificats.show', compact('certification'));
    }
    
    // Supprime une certification de la base de données
    public function destroy(Certification $certification)
    {
        $certification->delete();

        return redirect()->route('certifications.index')->with('success', 'Certification supprimée avec succès');
    }
    public function downloadPDF($id)
    {
        $certification = Certification::findOrFail($id); // Find the certification by ID

        // Load a view to generate PDF content
        $pdf = PDF::loadView('certificats.pdf', compact('certification'));

        // Return the generated PDF
        return $pdf->download('certificat_' . $certification->nom . '.pdf');
    }
}
