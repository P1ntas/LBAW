<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\Admin as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;
    public $table = 'admins';
    public $timestamps  = false;
    public $fillable = [
        'name',
        'email',
        'password'
    ];

    protected $hidden = [
        'password', 'remember_token'
    ];

    public function photo()
    {
        return $this->hasOne(\App\Models\Photo::class);
    }
}
