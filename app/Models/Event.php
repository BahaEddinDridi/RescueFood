<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'date',
        'location',
        'partner_id', // Foreign key for the partner
        'generated_description',
    ];

    /**
     * Get the partner (donor/beneficiary) associated with the event.
     */
    public function partner()
    {
        return $this->belongsTo(User::class, 'partner_id');
    }
}
