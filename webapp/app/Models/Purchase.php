<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    public $table = 'offtheshelf.purchase';
    public $timestamps  = false;
    public $fillable = [
        'purchase_date',
        'id_user',
        'state_purchase'
    ];

    protected $casts = [
        'id_purchase' => 'integer',
        'purchase_date' => 'datetime',
        'id_user' => 'integer'
        // 'state_purchase' => PurchaseState::class
    ];

    public static $rules = [
        // rules
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function books()
    {
        return $this->belongsToMany(\App\Models\Book::class, 'offtheshelf.purchase_book');
    }

    public function delivery()
    {
        return $this->hasOne(\App\Models\Delivery::class);
    }
}
