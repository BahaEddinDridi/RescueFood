<?php

namespace App\Http\Controllers;

use App\Models\Certification;
use Illuminate\Http\Request;

class CertificationController extends Controller
{
    // Affiche la liste des certifications
    public function index()
    {
        $certifications = Certification::all();
        return view('certificats.index', compact('certifications'));
    }

    // Affiche le formulaire de création d'une certification
    public function create()
    {
        return view('certificats.create');
    }

    // Stocke une nouvelle certification dans la base de données
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_validation' => 'required|date',
            'statut' => 'required|string',
        ]);

        Certification::create($request->all());
        return redirect()->route('certifications.index')->with('success', 'Certification créée avec succès');
    }

    // Affiche le formulaire d'édition d'une certification
    public function edit(Certification $certification)
    {
        return view('certificats.edit', compact('certification'));
    }

    // Met à jour une certification existante
    public function update(Request $request, Certification $certification)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_validation' => 'required|date',
            'statut' => 'required|string',
        ]);

        $certification->update($request->all());
        return redirect()->route('certifications.index')->with('success', 'Certification mise à jour avec succès');
    }

    // Supprime une certification de la base de données
    public function destroy(Certification $certification)
    {
        $certification->delete();
        return redirect()->route('certifications.index')->with('success', 'Certification supprimée avec succès');
    }
}
