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
        // to do
        return redirect('/');
      }

      return view('pages.book', [
        'book' => $book, 
        'category' => $book->category, 
        'publisher' => $book->publisher,
        'authors' => $book->authors,
        'reviews' => $book->reviews
      ]);
    }

    public function list()
    {
      $books = Book::all();

      if (empty($books)) {
        // to do
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
        // error
        return redirect('/');
      }

      $book->delete();
      return $book;
    }

    public function edit($id)
    {
        $book = Book::find($id);

        if (empty($book)) {
            // to do
            return redirect('/');
        }

        return view('pages.edit_book', ['book' => $book]);
    }

    public function update(Request $request, $id) {
      $book = Book::find($id);

      if (empty($book)) {
          // error
          return redirect('/');
      }

      $book->save();
      return redirect()->back();
  }


    public function search(Request $request)
    {
      $books = Book::whereRaw("title @@ plainto_tsquery('" . $request->search . "')")->get();
      
      return view('pages.books', ['books' => $books]);
    }
}
