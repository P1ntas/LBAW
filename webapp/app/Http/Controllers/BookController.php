<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use App\Models\Author;
use App\Models\Review;

class BookController extends Controller
{
    public function show($id)
    {
      $book = Book::find($id);

      if (empty($book)) {
        return redirect('/');
      }

      $category = Category::find($book->category_id);
      $publisher = Publisher::find($book->publisher_id);
      if (empty($category) || empty($publisher)) {
        return redirect('/');
      }

      return view('pages.book', [
        'book' => $book, 
        'category' => $category, 
        'publisher' => $publisher,
        'authors' => $book->authors,
        'reviews' => $book->reviews
      ]);
    }

    public function list()
    {
      $books = Book::all();

      if (empty($books)) {
        return redirect('/');
      }

      return view('pages.books', ['books' => $books]);
    }

    public function create(Request $request)
    {
      $book = new Book();

      $book->title = $request->input('title');
      // inputs fields
      $book->save();

      return $book;
    }

    public function delete(Request $request, $id)
    {
      $book = Book::find($id);

      if (empty($book)) {
        return redirect('/');
      }

      $book->delete();
      return $book;
    }
}
