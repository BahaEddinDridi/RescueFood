<?php
namespace App\Http\Controllers\Admin;
use App\Models\ProduitAlimentaire;
use App\Http\Controllers\Controller;
use App\Models\Certification;
use Illuminate\Http\Request;

class CertificationAdminController extends Controller
{
  
    public function index()
    {    
        $certifications = Certification::with(['produit', 'produit.user'])->paginate(10); // Chargement de la relation 'produit' et pagination
        return view('admin.certificats.index', compact('certifications'));
    }

    public function create()
    {
        // Récupérez tous les produits à partir de la base de données
        $produits = ProduitAlimentaire::all();

        // Passez la variable $produits à la vue
        return view('admin.certificats.create', compact('produits'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_validation' => 'required|date',
            'statut' => 'required|string|in:active,inactive,pending,expired',
            'produit_id' => 'required|exists:produits_alimentaires,id', // Ajoutez cette ligne si vous avez ce champ
        ]);

        Certification::create($request->all());

        return redirect()->route('admin.certifications.index')->with('success', 'Certification ajoutée avec succès.');
    }

    public function show(Certification $certification)
    {
        return view('admin.certificats.show', compact('certification'));
    }

    public function edit(Certification $certification)
    {
        

        $produits = ProduitAlimentaire::all(); // Récupérer tous les produits
        return view('admin.certificats.edit', compact('certification', 'produits'));
    }

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

        return redirect()->route('admin.certifications.index')->with('success', 'Certification mise à jour avec succès');
    }

    public function destroy(Certification $certification)
    {
        $certification->delete();

        return redirect()->route('admin.certifications.index')->with('success', 'Certification supprimée avec succès.');
    }
}
