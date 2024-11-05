<?php

namespace App\Http\Controllers;
use App\Models\Demande;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class DemandeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Demande::query();

        if (Auth::user()->role === 'donateur') {
            // Donateurs voient toutes les demandes
            if ($request->has('statut')) {
                // Si des statuts sont sélectionnés, filtrer selon ces statuts
                $query->whereIn('statut', $request->input('statut'));
            }
        } else {
            // Bénéficiaires voient seulement leurs propres demandes
            $query->where('beneficiaire_id', Auth::id());
    
            if ($request->has('statut')) {
                // Si des statuts sont sélectionnés, filtrer selon ces statuts
                $query->whereIn('statut', $request->input('statut'));
            }
        }
    
        // Récupérer toutes les demandes si aucune case à cocher n'est sélectionnée
        $demandes = $query->get();
    
        return view('demandes.index', compact('demandes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Récupère uniquement les utilisateurs avec le rôle 'bénéficiaire'
        $beneficiaries = User::where('role', 'beneficiaire')->get();
        return view('demandes.create', compact('beneficiaries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type_aliment' => 'required|regex:/^[A-Za-z\s]+$/', // Accepts only letters and spaces
            'quantite' => 'required|integer|min:1',
            'date_demande' => 'required|date',
            'statut' => 'required|string',
        ]);

        $demande = new Demande($validated);
        
        // Associe automatiquement le bénéficiaire à la demande
        if (Auth::user()->role === 'beneficiaire') {
            $demande->beneficiaire_id = Auth::id();
        } else {
            $demande->beneficiaire_id = $request->beneficiaire_id; // pour donateur
        }

        $demande->save();
        
        return redirect()->route('demandes.index')->with('success', 'Demande créée avec succès');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Demande::find($id);
        return view('demandes.show', compact('demande'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $demande = Demande::find($id);
        return view('demandes.edit', compact('demande'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'beneficiaire_id' => 'required',
            'type_aliment' => 'required',
            'quantite' => 'required|integer',
            'date_demande' => 'required|date',
            'statut' => 'required',
        ]);
        $demande = Demande::find($id);
        $demande->update($request->all()); 
        return redirect()->route('demandes.index')->with('success', 'Demande mise à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Demande::find($id)->delete(); 
        return redirect()->route('demandes.index')->with('success', 'Demande supprimée avec succès');
    }
}
