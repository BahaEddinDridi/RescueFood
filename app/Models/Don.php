<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Don extends Model
{
    use HasFactory;

    protected $table = 'don';
    protected $primaryKey ='id';
    protected $fillable = ['user_id', 'type_aliment', 'quantité', 'date_peremption', 'date_don', 'statut'];

    public function user()
    {
        return $this->belongsTo(User::class); 
    }
}
