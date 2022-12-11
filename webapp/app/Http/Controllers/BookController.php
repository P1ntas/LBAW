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
/*
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

      $validator = Validator::make($request->all(), [
          'title' => 'string|max:255',
          'isbn' => [Rule::unique('books')->ignore($book->id), 'string', 'isbn', 'regex:/^[1-9][1-9][1-9][1-9][1-9][1-9][1-9][1-9][1-9][1-9]$/'],
          'year' => 'string|max:255',
          'price' => 'integer|min:0',
          'stock' => 'integer|min:0',
          'book_edition' => 'string|max:255',
          'book_description' => 'string|max:255',
          'category' => 'string|max:255',
          'publisher' => 'string|max:255',

      ]);

      if ($validator->fails()) {
          // error
          return redirect('/');
      }

      if (isset($request->user_address)) {
          $validator = Validator::make($request->all(), [
              'user_address' => 'string|min:8|max:255'
          ]);

          if ($validator->fails()) {
              // error
              return redirect('/');
          }
      }

      if (isset($request->phone)) {
          $validator = Validator::make($request->all(), [
              'phone' => 'regex:/^[1-9][1-9][1-9][1-9][1-9][1-9][1-9][1-9][1-9]$/'
          ]);

          if ($validator->fails()) {
              // error
              return $validator;
          }
      }

      if ($request->password != $request->password_confirmation) {
          // error
          return redirect('/');
      }

      if (isset($request->password)) {
          $validator = Validator::make($request->all(), [
              'password' => 'string|min:3'
          ]);
  
          if ($validator->fails()) {
              // error
              return redirect('/');
          }

          if ($request->password == $request->password_confirmation) {
              $user->password = bcrypt($request->password);
          }
      }

      $user->name = $request->name;
      $user->email = $request->email;

      if (isset($request->user_address)) {
          $user->user_address = $request->user_address;
      }
      else {
          $user->user_address = $user->user_address;
      }

      if (isset($request->user_phone)) {
          $user->phone = $request->phone;
      }
      else {
          $user->phone = $user->phone;
      }

      if (isset($request->blocked)) {
          $user->blocked = $request->blocked;
      }
      else {
          $user->blocked = $user->blocked;
      }

      $user->save();
      return redirect()->back();
  }
*/
    public function search(Request $request)
    {
      $books = Book::whereRaw("title @@ plainto_tsquery('" . $request->search . "')")->get();
      
      return view('pages.books', ['books' => $books]);
    }
}
