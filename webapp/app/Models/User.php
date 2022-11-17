<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    public $table = 'users';
    public $timestamps  = false;
    public $fillable = [
        'name',
        'email',
        'password',
        'user_address',
        'phone',
        'blocked'
    ];

    protected $hidden = ['password'];

    public function wishlists()
    {
        return $this->belongsToMany(\App\Models\Book::class, 'wishlist');
    }

    public function carts()
    {
        return $this->belongsToMany(\App\Models\Book::class, 'cart');
    }

    public function reviews()
    {
        return $this->hasMany(\App\Models\Review::class);
    }

    public function purchases()
    {
        return $this->hasMany(\App\Models\Purchase::class);
    }

    public function photo()
    {
        return $this->hasOne(\App\Models\Photo::class);
    }

    public function isBlocked() {
        return $this->blocked;
    }
}
