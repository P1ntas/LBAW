<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    public $table = 'offtheshelf.users';
    public $timestamps  = false;
    public $fillable = [
        'username',
        'email',
        'user_password',
        'user_address',
        'phone',
        'blocked'
    ];

    protected $casts = [
        'id_user' => 'integer',
        'username' => 'text',
        'email' => 'text',
        'user_password' => 'text',
        'user_address' => 'address',
        'phone' => 'char',
        'blocked' => 'boolean'
    ];

    protected $hidden = [
        'user_password', 'remember_token',
    ];

    public static $rules = [
        // rules
    ];

    public function wishlists()
    {
        return $this->belongsToMany(\App\Models\Book::class, 'offtheshelf.wishlist');
    }

    public function carts()
    {
        return $this->belongsToMany(\App\Models\Book::class, 'offtheshelf.cart');
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
