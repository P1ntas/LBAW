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

      return view('pages.book', ['book' => $book]);
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

    public function review(Request $request, $id) {
      $review = new Review();

      $review->rating = $request->rating;
      $review->comment = $request->comment;
      $review->book_id = $id;
      $review->user_id = $request->user_id;
      $review->save();

      return $review;
    }

    public function removeReview(Request $request, $id) {
      $review = Review::where('book_id', $id)->where('user_id', $request->user_id)->first();
      $review->delete();

      return $review;
    }

    public function search(Request $request)
    {
      $books = Book::whereRaw("title @@ plainto_tsquery('" . $request->search . "')")->get();
      
      return view('pages.books', ['books' => $books]);
    }
}
