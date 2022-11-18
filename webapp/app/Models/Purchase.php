<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    public $table = 'purchase';
    public $timestamps  = false;

    public $fillable = [
        'purchase_date',
        'id_user',
        'state_purchase'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function books()
    {
        return $this->belongsToMany(\App\Models\Book::class, 'purchase_book', 'purchase_id', 'book_id');
    }

    public function delivery()
    {
        return $this->hasOne(\App\Models\Delivery::class);
    }
}
