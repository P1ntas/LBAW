<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public $table = 'book';
    public $timestamps  = false;
    public $fillable = [
        'title',
        'isbn',
        'year',
        'price',
        'stock',
        'book_edition',
        'book_description',
        'category_id',
        'publisher_id'
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
        return $this->belongsToMany(\App\Models\Author::class, 'book_author', 'book_id', 'author_id');
    }

    public function collections()
    {
        return $this->belongsToMany(\App\Models\Collection::class, 'book_collection', 'book_id', 'collection_id');
    }

    public function purchases()
    {
        return $this->belongsToMany(\App\Models\Purchase::class, 'purchase_book', 'book_id', 'purchase_id');
    }

    public function wishlists()
    {
        return $this->belongsToMany(\App\Models\User::class, 'wishlist', 'book_id', 'user_id');
    }

    public function carts()
    {
        return $this->belongsToMany(\App\Models\User::class, 'cart', 'book_id', 'user_id');
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
