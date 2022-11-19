<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    public $table = 'review';
    public $timestamps  = false;
    public $fillable = [
        'rating',
        'comment',
        'review_date',
        'book_id',
        'user_id'
    ];

    public function book()
    {
        return $this->belongsTo(\App\Models\Book::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
