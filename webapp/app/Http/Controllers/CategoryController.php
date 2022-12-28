<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\Category;

class CategoryController extends Controller
{
    public function list() {
        $categories = Category::simplePaginate(20);

        if ($categories->isEmpty()) {
            Session::flash('notification', 'Categories not found!');
            Session::flash('notification_type', 'error');

            return redirect('/');
        }

        return view('pages.categories', ['categories' => $categories]);
    }
}
