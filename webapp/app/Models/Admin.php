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
        'admin_name',
        'email',
        'admin_password'
    ];

    protected $casts = [
        'id_admin' => 'integer',
        'admin_name' => 'text',
        'email' => 'text',
        'admin_password' => 'text'
    ];

    protected $hidden = [
        'admin_password', 'remember_token',
    ];

    public static $rules = [
        // rules
    ];

    public function photo()
    {
        return $this->hasOne(\App\Models\Photo::class);
    }
}
