<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProduitAlimentaire;

class Certification extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
        'date_validation',
        'statut',
        'produit_id', // Ajoutez ce champ
    ];

    // Relation avec le modèle Produit
    public function produit()
    {
        return $this->belongsTo(ProduitAlimentaire::class);
    }
}
