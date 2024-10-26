<?php

namespace App\Http\Controllers\SPARQL;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use EasyRdf\Sparql\Client;

class CertificationspqlController extends Controller
{
    private $sparql;

    public function __construct()
    {
        // Set the SPARQL endpoint URL
        $this->sparql = new Client('http://localhost:3030/RescueFood/sparql');
    }

    // 1. List all certifications
    public function index()
    {
        $query = "
            PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
            PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>

            SELECT ?certification ?label ?description ?date_creation ?date_validite
            WHERE {
                ?certification a <http://www.semanticweb.org/user/ontologies/2024/8/untitled-ontology-8#Certification> .
                OPTIONAL { ?certification rdfs:label ?label }
                OPTIONAL { ?certification <http://www.semanticweb.org/user/ontologies/2024/8/untitled-ontology-8#description_certif> ?description }
                OPTIONAL { ?certification <http://www.semanticweb.org/user/ontologies/2024/8/untitled-ontology-8#date_creation_certif> ?date_creation }
                OPTIONAL { ?certification <http://www.semanticweb.org/user/ontologies/2024/8/untitled-ontology-8#date_validite_certif> ?date_validite }
            }
        ";

        try {
            $results = $this->sparql->query($query);

            // Transform SPARQL results into a more usable array for the view
            $certifications = [];
            foreach ($results as $row) {
                $certifications[] = [
                    'uri' => (string) $row->certification,
                    'label' => $row->label ?? 'N/A',
                    'description' => $row->description ?? 'N/A',
                    'date_creation' => $row->date_creation ?? 'N/A',
                    'date_validite' => $row->date_validite ?? 'N/A',
                ];
            }

            return view('sparql.certifications.index', compact('certifications'));

        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur de requête SPARQL: ' . $e->getMessage()]);
        }
    }

    // 2. Show form to create a new certification
    public function create()
    {
        return view('sparql.certifications.create');
    }

    // 3. Store new certification in the RDF graph
   

    public function store(Request $request)
    {
        // Debugging output
        \Log::info($request->all()); // Log all request data
    
        // Validation des données
        $request->validate([
            'label' => 'required|string|max:255',
            'uri' => 'required|url'
        ]);
    
        // Requête SPARQL pour insérer une nouvelle certification
        $query = "
            PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
            PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
            PREFIX ont: <http://www.semanticweb.org/user/ontologies/2024/8/untitled-ontology-8#>
    
            INSERT DATA {
                <{$request->input('uri')}> a ont:Certification ;
                    rdfs:label \"" . addslashes($request->input('label')) . "\" .
            }";
    
        try {
            $this->sparql->update($query);
            return redirect()->route('certificats.index')->with('success', 'Certification ajoutée avec succès!');
        } catch (\Exception $e) {
            \Log::error('SPARQL Update Error: ' . $e->getMessage()); // Log the error message
            return redirect()->route('certificats.index')->with('error', 'Erreur lors de l\'ajout: ' . $e->getMessage());
        }
    }
    


    // 4. Delete a certification
    public function destroy($uri)
    {
        try {
            // SPARQL query to delete the given certification
            $query = "
                DELETE WHERE {
                    <$uri> ?p ?o
                }
            ";

            $this->sparql->update($query);
            return redirect()->route('certificats.index')->with('success', 'Certification supprimée.');
        } catch (\Exception $e) {
            return redirect()->route('certificats.index')->with('error', 'Erreur lors de la suppression: ' . $e->getMessage());
        }
    }
}
