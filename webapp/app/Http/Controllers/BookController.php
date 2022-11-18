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

      if (empty($book)) {
        Flash::error('Book not found');
        return redirect('/');
      }

      return view('pages.book', ['book' => $book]);
    }

    public function list()
    {
      $books = Book::all();

      if (empty($books)) {
        Flash::error('No books');
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
        Flash::error('Book not found');
        return redirect('/');
      }

      $book->delete();
      return $book;
    }
}
