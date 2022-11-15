<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    public $table = 'offtheshelf.delivery';
    public $timestamps  = false;
    public $fillable = [
        'arrival',
        'delivery_address',
        'cost',
        'id_purchase'
    ];

    protected $casts = [
        'id_delivery' => 'integer',
        'arrival' => 'datetime',
        'delivery_address' => 'text',
        'cost' => 'numeric',
        'id_purchase' = 'integer'
    ];

    public static $rules = [
        // rules
    ];

    public function purchase()
    {
        return $this->hasOne(\App\Models\Purchase::class);
    }
}
