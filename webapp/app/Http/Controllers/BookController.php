<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use App\Models\Author;
use App\Models\Review;
use App\Models\Photo;

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

      $author = Author::where('name', $request->author_name)->first();
      if (empty($author)) {
        $author = new Author();
        $author->name = $request->author_name;
        $author->save();
      }
      $book->authors()->attach($author);

      $photo = Photo::where('name', $request->photo_image)->first();
      if (empty($photo)) {
        $photo = new Photo();
        $photo->photo_image = $request->photo_image;
        $photo->save();
      }
      $book->photos()->attach($photo);

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

      $book->title = $request->title;
      $book->isbn = $request->isbn;
      $book->year = $request->year;
      $book->price = $request->price;
      $book->stock = $request->stock;
      $book->book_edition = $request->book_edition;
      $book->book_description = $request->book_description;

      $category = Category::where('name', $request->category)->first();
      $book->category_id = $category->id;

      $publisher = Publisher::where('name', $request->publisher)->first();
      $book->publisher_id = $publisher->id;

      $book->save();

      $author = Author::where('name', $request->author_name)->first();
      if (empty($author)) {
        $author = new Author();
        $author->name = $request->author_name;
        $author->save();
      }
      $book->authors()->attach($author);
      

      return Redirect::to('/books/$book->id');

  }


    public function search(Request $request)
    {
      $books = Book::whereRaw("title @@ plainto_tsquery('" . $request->search . "')")->get();
      
      return view('pages.books', ['books' => $books]);
    }
}
