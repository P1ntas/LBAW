<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    public $table = 'author';
    public $timestamps  = false;
    public $fillable = [
        'name'
    ];

    public function books()
    {
        return $this->belongsToMany(\App\Models\Book::class, 'book_author', 'author_id', 'book_id');
    }
}
