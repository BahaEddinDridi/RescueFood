<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'titre',
        'contenu',
        'type_post',
        'user_id',
        'image_url'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function likes()
{
    return $this->hasMany(Like::class);
}
public function isLikedByUser()
{
    return $this->likes()->where('user_id', auth()->id())->exists();
}
public function comments()
{
    return $this->hasMany(Comment::class);
}
public function notifications()
{
    return $this->morphMany(Notification::class, 'notifiable');
}
}
