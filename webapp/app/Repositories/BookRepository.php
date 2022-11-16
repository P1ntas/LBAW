<?php

namespace App\Repositories;

use App\Models\Book;
use App\Repositories\BaseRepository;

class BookRepository extends BaseRepository
{
    protected $fieldSearchable = [
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

    public function model()
    {
        return Book::class;
    }
}
