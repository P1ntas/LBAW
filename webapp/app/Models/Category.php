<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $table = 'category';
    public $timestamps  = false;
    public $fillable = [
        'name'
    ];

    public function books()
    {
        return $this->hasMany(\App\Models\Book::class);
    }
}
