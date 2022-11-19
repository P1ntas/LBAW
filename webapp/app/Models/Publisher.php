<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    public $table = 'publisher';
    public $timestamps  = false;
    public $fillable = [
        'name'
    ];

    public function books()
    {
        return $this->hasMany(\App\Models\Book::class);
    }
}
