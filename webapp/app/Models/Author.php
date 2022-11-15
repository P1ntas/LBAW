<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    public $table = 'offtheshelf.author';
    public $timestamps  = false;
    public $fillable = [
        'author_name'
    ];

    protected $casts = [
        'id_author' => 'integer',
        'author_name' => 'text'
    ];

    public static $rules = [
        // rules        
    ];

    public function books()
    {
        return $this->belongsToMany(\App\Models\Book::class, 'offtheshelf.book_author');
    }
}
