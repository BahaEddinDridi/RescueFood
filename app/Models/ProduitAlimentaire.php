<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ProduitAlimentaire extends Model
{
    use HasFactory;
    protected $table = 'produits_alimentaires';
    protected $fillable = [
        'user_id',
        'nom',
        'categorie',
        'quantite',
        'date_peremption',
        'type',
        'image_url',
    ];

      // Relation avec le modèle Certification
    //   public function certifications()
    //   {
    //       return $this->hasMany(Certification::class);
    //   }
    public function certification()
    {
        return $this->hasOne(Certification::class, 'produit_id'); 
    }

        // Relation avec le modèle User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
