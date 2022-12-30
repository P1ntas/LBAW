<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\Book;
use App\Models\Category;
use App\Models\Author;
use App\Models\Review;

class BookController extends Controller
{
    public function list() {
        $books = Book::simplePaginate(10);

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

    public function show($id) {
        $book = Book::find($id);

        if (empty($book)) {
            Session::flash('notification', 'Book not found!');
            Session::flash('notification_type', 'error');

            return redirect()->back();
        }

        return view('pages.book', ['book' => $book]);
    }

    public function filter(Request $request) {
        $query = Book::query();
  
        if (isset($request->category)) {
            $category = Category::where('name', $request->category)->first();

            if (!empty($category)) {
                $query->where('category_id', $category->id);
            }
        }
  
        if (isset($request->price_min)) {
            $query->where('price', '>=', $request->price_min);
        }
  
        if (isset($request->price_max)) {
            $query->where('price', '<=', $request->price_max);
        }
  
        $books = $query->simplePaginate(10);

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

    public function search(Request $request) {
        $results = Book::whereRaw("title @@ plainto_tsquery('" . $request->search . "')")->simplePaginate(10);

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

    public function review(Request $request, $id) {
        $book = Book::find($id);

        if (empty($book)) {
            Session::flash('notification', 'Book not found!');
            Session::flash('notification_type', 'error');

            return redirect()->back();
        }

        $validator = Validator::make($request->all(), [
                'rating' => 'required|numeric|min:0|max:5'
            ], 
            [
                'rating.required' => 'Please enter a rating',
                'rating.numeric' => 'The rating must be a number',
                'rating.min' => 'The rating must be at least 0',
                'rating.max' => 'The rating must be no more than 5'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back();
        }

        if (isset($request->comment)) {
            $validator = Validator::make($request->all(), [
                'comment' => 'string'
            ]);

            if ($validator->fails()) {
                return redirect()->back();
            }
        }

        $review = new Review();

        $review->rating = $request->rating;
        if (isset($request->comment)) {
            $review->comment = $request->comment;
        }
        $review->book_id = $id;
        $review->user_id = Auth::user()->id;
        $review->save();

        return redirect()->action('BookController@show', ['id' => $id]);
    }

    public function removeReview($book_id, $review_id)
    {
        $review = Review::find($review_id);

        if (empty($review)) {
            Session::flash('notification', 'Review not found!');
            Session::flash('notification_type', 'error');

            return redirect()->back();
        }

        $user = app('App\Http\Controllers\UserController')->getUser($review->user_id);

        try {
            $this->authorize('removeReview', $user);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return redirect()->back();
        }

        $review->delete();

        return redirect()->back();
    }

    public function editReview(Request $request, $book_id, $review_id) {
        $review = Review::find($review_id);

        if (empty($review)) {
            Session::flash('notification', 'Review not found!');
            Session::flash('notification_type', 'error');

            return redirect()->back();
        }
        
        $user = app('App\Http\Controllers\UserController')->getUser($review->user_id);

        try {
            $this->authorize('editReview', $user);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return redirect()->back();
        }

        $validator = Validator::make($request->all(), [
                'rating' => 'required|numeric|min:0|max:5'
            ], 
            [
                'rating.required' => 'Please enter a rating',
                'rating.numeric' => 'The rating must be a number',
                'rating.min' => 'The rating must be at least 0',
                'rating.max' => 'The rating must be no more than 5'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back();
        }

        if (isset($request->comment)) {
            $validator = Validator::make($request->all(), [
                'comment' => 'string'
            ]);

            if ($validator->fails()) {
                return redirect()->back();
            }
        }

        $review->rating = $request->rating;
        if (isset($request->comment)) {
            $review->comment = $request->comment;
        }
        $review->book_id = $book_id;
        $review->user_id = Auth::user()->id;
        $review->save();

        return redirect()->back();
    }
}
