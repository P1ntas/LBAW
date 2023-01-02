<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword;

class User extends Authenticatable
{
    use Notifiable;

    public $table = 'users';
    public $timestamps  = false;
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_address',
        'phone',
        'blocked',
        'admin_perms'
    ];

    protected $hidden = ['password', 'remember_token'];

    public function wishlist()
    {
        return $this->belongsToMany(\App\Models\Book::class, 'wishlist', 'user_id', 'book_id');
    }

    public function cart()
    {
        return $this->belongsToMany(\App\Models\Book::class, 'cart', 'user_id', 'book_id');
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

    public function notifications()
    {
        return $this->hasMany(\App\Models\Notification::class);
    }

    public function isBlocked() {
        return $this->blocked;
    }

    public function isAdmin() {
        return $this->admin_perms;
    }
}
