<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $table = 'offtheshelf.category';
    public $timestamps  = false;
    public $fillable = [
        'category_name'
    ];

    protected $casts = [
        'id_category' => 'integer',
        'category_name' => 'text'
    ];

    public static $rules = [
        // rules        
    ];

    public function books()
    {
        return $this->hasMany(\App\Models\Book::class);
    }
}
