<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FAQ extends Model
{
    public $table = 'faq';
    public $timestamps  = false;

    protected $casts = [
        'question' => 'text',
        'answer' => 'text'
    ];

    public static $rules = [
        // rules        
    ];
}
