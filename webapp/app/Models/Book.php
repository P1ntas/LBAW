<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public $table = 'offtheshelf.book';
    public $timestamps  = false;
    public $fillable = [
        'title',
        'isbn',
        'year',
        'price',
        'stock',
        'book_edition',
        'book_description',
        'id_category',
        'id_publisher'
    ];

    protected $casts = [
        'id_book' => 'integer',
        'title' => 'text',
        'isbn' => 'numeric',
        'year' => 'integer',
        'price' => 'numeric'
        'stock' => 'numeric',
        'book_edition' => 'integer',
        'book_description' => 'text',
        'id_category' => 'integer',
        'id_publisher' => 'integer'
    ];

    public static $rules = [
        // rules        
    ];

    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class);
    }

    public function publisher()
    {
        return $this->belongsTo(\App\Models\Publisher::class);
    }

    public function authors()
    {
        return $this->belongsToMany(\App\Models\Author::class, 'offtheshelf.book_author');
    }

    public function collections()
    {
        return $this->belongsToMany(\App\Models\Collection::class, 'offtheshelf.book_collection');
    }

    public function purchases()
    {
        return $this->belongsToMany(\App\Models\Purchase::class, 'offtheshelf.purchase_book');
    }

    public function wishlists()
    {
        return $this->belongsToMany(\App\Models\User::class, 'offtheshelf.wishlist');
    }

    public function carts()
    {
        return $this->belongsToMany(\App\Models\User::class, 'offtheshelf.cart');
    }

    public function photos()
    {
        return $this->hasMany(\App\Models\Photo::class);
    }

    public function reviews()
    {
        return $this->hasMany(\App\Models\Review::class);
    }
}
