<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    public function upload(Request $request)
    {
    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $image = $request->file('image');
    $path = $image->store('images');

    // Save the path to the image in the database...
    }
}
