<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\Book;
use App\Models\Category;
use App\Models\Author;

class BookController extends Controller
{
    public function list() {
        $books = Book::simplePaginate(20);

        if ($books->isEmpty()) {
            Session::flash('notification', 'Books not found!');
            Session::flash('notification_type', 'error');

            return redirect('/');
        }

        $categories = Category::all();

        if ($categories->isEmpty()) {
            Session::flash('notification', 'Categories not found!');
            Session::flash('notification_type', 'error');

            return redirect('/');
        }

        return view('pages.books', [
            'books' => $books,
            'categories' => $categories
        ]);
    }

    public function show($id)
    {
        $book = Book::find($id);

        if (empty($book)) {
            Session::flash('notification', 'Book not found!');
            Session::flash('notification_type', 'error');

            return redirect('/books');
        }

        return view('pages.book', ['book' => $book]);
    }

    public function filter(Request $request) {
        $query = Book::query();
  
        if (isset($request->category)) {
            $category = Category::where('name', $request->category)->first();
            $query->where('category_id', $category->id);
        }
  
        if (isset($request->price_min)) {
            $query->where('price', '>=', $request->price_min);
        }
  
        if (isset($request->price_max)) {
            $query->where('price', '<=', $request->price_max);
        }
  
        $books = $query->simplePaginate(20);

        $categories = Category::all();

        if ($categories->isEmpty()) {
            Session::flash('notification', 'Categories not found!');
            Session::flash('notification_type', 'error');

            return redirect('/');
        }
  
        return view('pages.books', [
            'books' => $books,
            'categories' => $categories,
            'category' => $request->category,
            'price_min' => $request->price_min,
            'price_max' => $request->price_max
        ]);
    } 

    public function search(Request $request)
    {
        $results = Book::whereRaw("title @@ plainto_tsquery('" . $request->search . "')")->simplePaginate(20);

        if ($results->isEmpty()) {
            $authors = Author::whereRaw("name @@ plainto_tsquery('" . $request->search . "')")->get();
            $results = Book::whereHas('authors', function($query) use ($authors) {
                $query->whereIn('author_id', $authors->pluck('id'));
            })->paginate(20);
        }

        $categories = Category::all();

        if ($categories->isEmpty()) {
            Session::flash('notification', 'Categories not found!');
            Session::flash('notification_type', 'error');

            return redirect('/');
        }
        
        return view('pages.books', [
            'books' => $results,
            'categories' => $categories
        ]);
    }
}
