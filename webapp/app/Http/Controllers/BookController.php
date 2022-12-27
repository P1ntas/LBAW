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

    public function addBook($id) {
      $categories = Category::all();
      $publishers = Publisher::all();

      return view('pages.add_book', ['categories' => $categories, 'publishers' => $publishers]);
    }

    public function create(Request $request)
    {
      $book = new Book();

      $book->title = $request->title;
      $book->isbn = $request->isbn;
      $book->year = $request->year;
      $book->price = $request->price;
      $book->stock = $request->stock;
      $book->book_edition = $request->book_edition;
      $book->book_description = $request->book_description;
      $category = Category::where('name', $request->category_name)->first();
      $book->category_id = $category->id;
      $publisher = Publisher::where('name', $request->publisher_name)->first();
      $book->publisher_id = $publisher->id;
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
