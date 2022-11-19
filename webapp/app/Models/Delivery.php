<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    public $table = 'delivery';
    public $timestamps  = false;
    public $fillable = [
        'arrival',
        'delivery_address',
        'cost',
        'purchase_id'
    ];

    public function purchase()
    {
        return $this->hasOne(\App\Models\Purchase::class);
    }
}
