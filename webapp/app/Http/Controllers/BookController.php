<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\Book;
use App\Models\Category;

class BookController extends Controller
{
    public function list() {
        $books = Book::paginate(20);

        if ($books->isEmpty()) {
            Session::flash('notification', 'Books not found!');
            Session::flash('notification_type', 'error');

            return redirect('/');
        }

        return view('pages.books', ['books' => $books]);
    }
}
