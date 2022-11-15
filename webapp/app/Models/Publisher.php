<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    public $table = 'offtheshelf.publisher';
    public $timestamps  = false;
    public $fillable = [
        'publisher_name'
    ];

    protected $casts = [
        'id_publisher' => 'integer',
        'publisher_name' => 'text'
    ];

    public static $rules = [
        // rules        
    ];

    public function books()
    {
        return $this->hasMany(\App\Models\Book::class);
    }
}
