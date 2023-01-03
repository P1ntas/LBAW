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
use App\Models\Publisher;
use App\Models\Author;
use App\Models\Review;
use App\Models\User;

class BookController extends Controller
{
    public function list() {
        $books = Book::simplePaginate(8);

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
        $request->replace(array_map(function($value) {
            return is_string($value) ? strip_tags($value) : $value;
        }, $request->all()));

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
  
        $books = $query->simplePaginate(8);

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
        $request->replace(array_map(function($value) {
            return is_string($value) ? strip_tags($value) : $value;
        }, $request->all()));

        $validator = Validator::make($request->all(), [
                'search' => 'escape_html|string|max:100'
            ], 
            [
                'search.escape_html' => 'The search field may not contain any special characters.',
                'search.string' => 'The search field must be a string.',
                'search.max' => 'The search field may not be more than 100 characters.',
            ]
        );

        if ($validator->fails()) {
            return redirect('/');
        }

        $results = Book::whereRaw("title @@ plainto_tsquery('" . $request->search . "')")->simplePaginate(8);

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
        $request->replace(array_map(function($value) {
            return is_string($value) ? strip_tags($value) : $value;
        }, $request->all()));

        try {
            $book = Book::find($id);

            if (empty($book)) {
                Session::flash('notification', 'Book not found!');
                Session::flash('notification_type', 'error');

                return redirect()->back();
            }

            $validator = Validator::make($request->all(), [
                    'rating' => 'required|escape_html|numeric|min:0|max:5'
                ], 
                [
                    'rating.required' => 'Please enter a rating',
                    'rating.escape_html' => 'The rating field may not contain any special characters.',
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
                    'comment' => 'escape_html|string'
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
        catch (\Exception $e) {
            if ($e->getMessage() == 'Blocked users cannot submit reviews.') {
                Session::flash('notification', 'You cannot submit reviews because you are blocked.');
                Session::flash('notification_type', 'error');
    
                return redirect()->back();
            } 
            else {
                return redirect()->back();
            }
        }
    }

    public function removeReview($book_id, $review_id) {
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
        $request->replace(array_map(function($value) {
            return is_string($value) ? strip_tags($value) : $value;
        }, $request->all()));

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
                'rating' => 'required|escape_html|numeric|min:0|max:5'
            ], 
            [
                'rating.required' => 'Please enter a rating',
                'rating.escape_html' => 'The rating field may not contain any special characters.',
                'rating.numeric' => 'The rating must be a number',
                'rating.min' => 'The rating must be at least 0',
                'rating.max' => 'The rating must be no more than 5'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        if (isset($request->comment)) {
            $validator = Validator::make($request->all(), [
                'comment' => 'escape_html|string'
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

    public function add() {
        $categories = Category::all();

        if ($categories->isEmpty()) {
            Session::flash('notification', 'Categories not found!');
            Session::flash('notification_type', 'error');

            return redirect('/');
        }

        $publishers = Publisher::all();
  
        if ($publishers->isEmpty()) {
            Session::flash('notification', 'Publishers not found!');
            Session::flash('notification_type', 'error');

            return redirect('/');
        }

        try {
            $this->authorize('addBook', User::class);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return redirect()->back();
        }
  
        return view('pages.add_book', [
            'categories' => $categories, 
            'publishers' => $publishers
        ]);
    }
  
    public function create(Request $request) {
        $request->replace(array_map(function($value) {
            return is_string($value) ? strip_tags($value) : $value;
        }, $request->all()));

        try {
            $this->authorize('addBook', User::class);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return redirect()->back();
        }

        $validator = Validator::make($request->all(), [
                'title' => 'required|escape_html|string|min:1|max:100',
                'isbn' => 'required|escape_html|numeric|max:9999999999999',
                'price' => 'required|escape_html|numeric|between:0.01,999.99',
                'stock' => 'required|escape_html|integer|min:0',
                'category_name' => 'required|escape_html|string|min:2|max:100',
                'authors' => 'regex:/^([A-Za-z.\s]+)(\/[A-Za-z.\s]+)*$/'
            ], 
            [
                'title.required' => ':attribute is required',
                'title.escape_html' => 'The title field may not contain any special characters.',
                'title.string' => ':attribute must be a string',
                'title.min' => ':attribute must be at least :min characters long',
                'title.max' => ':attribute cannot be more than :max characters long',
                'isbn.required' => ':attribute is required',
                'isbn.escape_html' => 'The isbn field may not contain any special characters.',
                'isbn.numeric' => ':attribute must be a numeric value',
                'isbn.max' => ':attribute cannot be more than :max',
                'price.required' => ':attribute is required',
                'price.escape_html' => 'The price field may not contain any special characters.',
                'price.numeric' => ':attribute must be a numeric value',
                'price.between' => ':attribute must be between :min and :max',
                'stock.required' => ':attribute is required',
                'stock.escape_html' => 'The stock field may not contain any special characters.',
                'stock.integer' => ':attribute must be an integer',
                'stock.min' => ':attribute must be at least :min',
                'category_name.string' => ':attribute must be a string',
                'category_name.escape_html' => 'The category_name field may not contain any special characters.',
                'category_name.min' => ':attribute must be at least :min characters long',
                'category_name.max' => ':attribute cannot be more than :max characters long',
                'authors.regex' => ':attribute must be in the format "Author Name/Author Name/Author Name"'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        if (isset($request->year)) {
            $validator = Validator::make($request->all(), [
                    'year' => 'escape_html|date_format:Y'
                ], 
                [
                    'year.escape_html' => 'The year field may not contain any special characters.',
                    'year.date_format' => ':attribute must be a valid year in the format YYYY'
                ]
            );

            if ($validator->fails()) {
                return redirect()->back();
            }
        }

        if (isset($request->book_edition)) {
            $validator = Validator::make($request->all(), [
                    'book_edition' => 'integer|escape_html|min:1|max:100'
                ], 
                [
                    'edition.integer' => ':attribute must be an integer',
                    'edition.escape_html' => 'The edition field may not contain any special characters.',
                    'edition.min' => ':attribute must be at least :min',
                    'edition.max' => ':attribute cannot be more than :max',
                ]
            );

            if ($validator->fails()) {
                return redirect()->back();
            }
        }

        if (isset($request->book_description)) {
            $validator = Validator::make($request->all(), [
                    'book_description' => 'string|escape_html|min:5|max:1000',
                ], 
                [
                    'book_description.string' => ':attribute must be a string',
                    'book_description.escape_html' => 'The book_description field may not contain any special characters.',
                    'book_description.min' => ':attribute must be at least :min characters long',
                    'book_description.max' => ':attribute cannot be more than :max characters long',
                ]
            );

            if ($validator->fails()) {
                return redirect()->back();
            }
        }

        if (isset($request->publisher_name)) {
            $validator = Validator::make($request->all(), [
                    'publisher_name' => 'string|escape_html|min:2|max:100'
                ], 
                [
                    'publisher_name.string' => ':attribute must be a string',
                    'publisher_name.escape_html' => 'The publisher_name field may not contain any special characters.',
                    'publisher_name.min' => ':attribute must be at least :min characters long',
                    'publisher_name.max' => ':attribute cannot be more than :max characters long',
                ]
            );

            if ($validator->fails()) {
                return redirect()->back();
            }
        }

        $book = new Book();

        $book->title = $request->title;
        $book->isbn = $request->isbn;
        if (isset($request->year)) {
            $book->year = $request->year;
        }
        $book->price = $request->price;
        $book->stock = $request->stock;
        if (isset($request->book_edition)) {
            $book->book_edition = $request->book_edition;
        }
        if (isset($request->book_description)) {
            $book->book_description = $request->book_description;
        }
        $category = Category::where('name', $request->category_name)->first();
        $book->category_id = $category->id;
        if (isset($request->publisher_name)) {
            $publisher = Publisher::where('name', $request->publisher_name)->first();
            $book->publisher_id = $publisher->id;
        }

        $book->save();

        $author_set = explode('/', $request->authors);
        $author_set = array_map('trim', $author_set);
        foreach ($author_set as $author_name) {
            $author = Author::where('name', $author_name)->first();
            if (empty($author)) {
                $author = new Author();
                $author->name = $author_name;
                $author->save();
            }
            $book->authors()->attach($author);
        }

        return redirect()->action('BookController@list');
    }

    public function edit($id) {
        $book = Book::find($id);

        if (empty($book)) {
            Session::flash('notification', 'Book not found!');
            Session::flash('notification_type', 'error');

            return redirect()->back();
        }

        $categories = Category::all();

        if ($categories->isEmpty()) {
            Session::flash('notification', 'Categories not found!');
            Session::flash('notification_type', 'error');

            return redirect('/');
        }

        $publishers = Publisher::all();
  
        if ($publishers->isEmpty()) {
            Session::flash('notification', 'Publishers not found!');
            Session::flash('notification_type', 'error');

            return redirect('/');
        }

        try {
            $this->authorize('editBook', User::class);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return redirect()->back();
        }

        $authors = implode('/', $book->authors->map(function($author) {
            return $author->name;
        })->toArray());
  
        return view('pages.edit_book', [
            'book' => $book,
            'categories' => $categories, 
            'publishers' => $publishers,
            'authors' => $authors
        ]);
    }

    public function update(Request $request, $id) {
        $request->replace(array_map(function($value) {
            return is_string($value) ? strip_tags($value) : $value;
        }, $request->all()));
        
        $book = Book::find($id);

        if (empty($book)) {
            Session::flash('notification', 'Book not found!');
            Session::flash('notification_type', 'error');

            return redirect()->back();
        }

        try {
            $this->authorize('editBook', User::class);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return redirect()->back();
        }

        $validator = Validator::make($request->all(), [
                'title' => 'required|escape_html|string|min:1|max:100',
                'isbn' => 'required|escape_html|numeric|max:9999999999999',
                'price' => 'required|escape_html|numeric|between:0.01,999.99',
                'stock' => 'required|escape_html|integer|min:0',
                'category_name' => 'required|escape_html|string|min:2|max:100',
                'authors' => 'regex:/^([A-Za-z.\s]+)(\/[A-Za-z.\s]+)*$/'
            ], 
            [
                'title.required' => ':attribute is required',
                'title.escape_html' => 'The title field may not contain any special characters.',
                'title.string' => ':attribute must be a string',
                'title.min' => ':attribute must be at least :min characters long',
                'title.max' => ':attribute cannot be more than :max characters long',
                'isbn.required' => ':attribute is required',
                'isbn.escape_html' => 'The isbn field may not contain any special characters.',
                'isbn.numeric' => ':attribute must be a numeric value',
                'isbn.max' => ':attribute cannot be more than :max',
                'price.required' => ':attribute is required',
                'price.escape_html' => 'The price field may not contain any special characters.',
                'price.numeric' => ':attribute must be a numeric value',
                'price.between' => ':attribute must be between :min and :max',
                'stock.required' => ':attribute is required',
                'stock.escape_html' => 'The stock field may not contain any special characters.',
                'stock.integer' => ':attribute must be an integer',
                'stock.min' => ':attribute must be at least :min',
                'category_name.string' => ':attribute must be a string',
                'category_name.escape_html' => 'The category_name field may not contain any special characters.',
                'category_name.min' => ':attribute must be at least :min characters long',
                'category_name.max' => ':attribute cannot be more than :max characters long',
                'authors.regex' => ':attribute must be in the format "Author Name/Author Name/Author Name"'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        if (isset($request->year)) {
            $validator = Validator::make($request->all(), [
                    'year' => 'escape_html|date_format:Y'
                ], 
                [
                    'year.escape_html' => 'The year field may not contain any special characters.',
                    'year.date_format' => ':attribute must be a valid year in the format YYYY'
                ]
            );

            if ($validator->fails()) {
                return redirect()->back();
            }
        }

        if (isset($request->book_edition)) {
            $validator = Validator::make($request->all(), [
                    'book_edition' => 'integer|escape_html|min:1|max:100'
                ], 
                [
                    'edition.integer' => ':attribute must be an integer',
                    'edition.escape_html' => 'The edition field may not contain any special characters.',
                    'edition.min' => ':attribute must be at least :min',
                    'edition.max' => ':attribute cannot be more than :max',
                ]
            );

            if ($validator->fails()) {
                return redirect()->back();
            }
        }

        if (isset($request->book_description)) {
            $validator = Validator::make($request->all(), [
                    'book_description' => 'string|escape_html|min:5|max:1000',
                ], 
                [
                    'book_description.string' => ':attribute must be a string',
                    'book_description.escape_html' => 'The book_description field may not contain any special characters.',
                    'book_description.min' => ':attribute must be at least :min characters long',
                    'book_description.max' => ':attribute cannot be more than :max characters long',
                ]
            );

            if ($validator->fails()) {
                return redirect()->back();
            }
        }

        if (isset($request->publisher_name)) {
            $validator = Validator::make($request->all(), [
                    'publisher_name' => 'string|escape_html|min:2|max:100'
                ], 
                [
                    'publisher_name.string' => ':attribute must be a string',
                    'publisher_name.escape_html' => 'The publisher_name field may not contain any special characters.',
                    'publisher_name.min' => ':attribute must be at least :min characters long',
                    'publisher_name.max' => ':attribute cannot be more than :max characters long',
                ]
            );

            if ($validator->fails()) {
                return redirect()->back();
            }
        }

        if ($book->price != $request->price) {
            $users = $book->carts;
            foreach ($users as $user) {
                $notification = app('App\Http\Controllers\NotificationController')->generate(
                    '' . $book->title . ' price update',
                    $user->id
                );
            }
        }

        if ($book->stock == 0 && $request->stock > 0) {
            $users = $book->wishlist;
            foreach ($users as $user) {
                $notification = app('App\Http\Controllers\NotificationController')->generate(
                    '' . $book->title . ' is now available',
                    $user->id
                );
            }
        }

        $book->title = $request->title;
        $book->isbn = $request->isbn;
        if (isset($request->year)) {
            $book->year = $request->year;
        }
        $book->price = $request->price;
        $book->stock = $request->stock;
        if (isset($request->book_edition)) {
            $book->book_edition = $request->book_edition;
        }
        if (isset($request->book_description)) {
            $book->book_description = $request->book_description;
        }
        $category = Category::where('name', $request->category_name)->first();
        $book->category_id = $category->id;
        if (isset($request->publisher_name)) {
            $publisher = Publisher::where('name', $request->publisher_name)->first();
            $book->publisher_id = $publisher->id;
        }

        $book->save();

        $book->authors()->detach();
        $author_set = explode('/', $request->authors);
        $author_set = array_map('trim', $author_set);
        foreach ($author_set as $author_name) {
            $author = Author::where('name', $author_name)->first();
            if (empty($author)) {
                $author = new Author();
                $author->name = $author_name;
                $author->save();
            }
            $book->authors()->attach($author);
        }

        return redirect()->action('BookController@show', ['id' => $id]);
    }

    public function delete($id) {
        try {
            $this->authorize('deleteBook', User::class);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return redirect()->back();
        }

        $book = Book::find($id);

        if (empty($book)) {
            Session::flash('notification', 'Book not found!');
            Session::flash('notification_type', 'error');

            return redirect()->back();
        }

        $book->delete();

        Session::flash('notification', 'This book has been deleted.');
        Session::flash('notification_type', 'success');
  
        return redirect()->action('BookController@list');
    }
}
