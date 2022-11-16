<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    public $table = 'photo';
    public $timestamps  = false;
    public $fillable = [
        'photo_image',
        'id_book',
        'id_user',
        'id_admin'
    ];

    protected $casts = [
        'id_photo' => 'integer',
        'photo_image' => 'text',
        'id_book' => 'integer',
        'id_user' => 'integer',
        'id_admin' => 'integer'
    ];

    public static $rules = [
        // rules
    ];

    public function book()
    {
        return $this->belongsTo(\App\Models\Book::class);
    }

    public function user()
    {
        return $this->hasOne(\App\Models\User::class);
    }

    public function admin()
    {
        return $this->hasOne(\App\Models\Admin::class);
    }
}
