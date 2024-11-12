<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'role',
        'phone_number',
        'birthdate',
        'sector',
        'association_name',
        'city',
        'bio',
        'profile_picture',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'birthdate' => 'date',
    ];
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Get full name for the user (first and last name combined).
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Check if the user has the 'donateur' role.
     *
     * @return bool
     */
    public function isDonateur()
    {
        return $this->role === 'donateur';
    }

    /**
     * Check if the user has the 'beneficiaire' role.
     *
     * @return bool
     */
    public function isBeneficiaire()
    {
        return $this->role === 'beneficiaire';
    }

    /**
     * Check if the user has the 'transporteur' role.
     *
     * @return bool
     */
    public function isTransporteur()
    {
        return $this->role === 'transporteur';
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function notifications()
{
    return $this->morphMany(Notification::class, 'notifiable');
}


}
