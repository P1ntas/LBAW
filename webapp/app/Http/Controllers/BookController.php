<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Book;

class BookController extends Controller
{
    public function show($id)
    {
      $book = Book::find($id);
      return view('pages.book', ['book' => $book]);
    }

    public function list()
    {
      $books = Book::orderBy('id')->get();
      return view('pages.books', ['books' => $books]);
    }

    public function create(Request $request)
    {
      $book = new Book();

      $this->authorize('create', $book);

      $book->title = $request->input('title');
      // inputs fields
      $book->save();

      return $book;
    }

    public function delete(Request $request, $id)
    {
      $book = Book::find($id);

      $this->authorize('delete', $book);
      $book->delete();

      return $book;
    }
}
