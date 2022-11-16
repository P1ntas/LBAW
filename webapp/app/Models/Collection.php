<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    public $table = 'collections';
    public $timestamps  = false;
    public $fillable = [
        'collection_name'
    ];

    protected $casts = [
        'id_collection' => 'integer',
        'collection_name' => 'text'
    ];

    public static $rules = [
        // rules        
    ];

    public function books()
    {
        return $this->belongsToMany(\App\Models\Book::class, 'book_collection');
    }
}
