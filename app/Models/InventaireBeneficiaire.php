<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProduitAlimentaire;
use App\Models\User;
class InventaireBeneficiaire extends Model
{
    use HasFactory;
    protected $table = 'inventaire_beneficiaire';
    protected $fillable = [
        'user_id',
        'produit_id',
        'quantite',
        'localisation', // Peut être nul
    ];

    public function produit()
    {
        return $this->belongsTo(ProduitAlimentaire::class);
    }

    public function beneficiaire()
    {
        return $this->belongsTo(User::class);
    }
}
