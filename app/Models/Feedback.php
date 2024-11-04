<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedbacks';

    protected $fillable = [
        'user_id',
        'type_feedback',
        'contenu_feedback',
    ];

     // Définition de la relation avec User
     public function user()
     {
         return $this->belongsTo(User::class);
     }

    // Validation du champ type_feedback
    public function setTypeFeedbackAttribute($value)
    {
        $validTypes = ['don', 'evenement', 'reservation'];
        
        if (!in_array($value, $validTypes)) {
            throw new \InvalidArgumentException("Invalid type_feedback value.");
        }

        $this->attributes['type_feedback'] = $value;
    }
}
