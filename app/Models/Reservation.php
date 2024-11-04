<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'beneficiare_id',
        'don_id',
        'date_reservation',
        'statut_reservation',
    ];

    protected $casts = [
        'date_reservation' => 'datetime',
    ];

    // Relation avec le modèle Don
    public function don()
    {
        return $this->belongsTo(Don::class, 'don_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'beneficiare_id');
    }


    // Mutator to set default values
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Set the default date to today's date if not provided
            if (is_null($model->date_reservation)) {
                $model->date_reservation = now();
            }

            // Set the default status if not provided
            if (is_null($model->statut_reservation)) {
                $model->statut_reservation = 'en_attente';
            }
        });
    }
}
