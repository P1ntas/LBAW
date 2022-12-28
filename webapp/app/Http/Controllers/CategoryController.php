<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Category;

class CategoryController extends Controller
{
    public function list()
    {
      $categories = Category::all();

      if (empty($categories)) {
        // to do
        return redirect('/');
      }

      return view('pages.categories', ['categories' => $categories]);
    }

    public function delete($id)
    {
      $category = Category::find($id);

      if (empty($category)) {
        // error
        return redirect('/');
      }

      $category->delete();
      return $book;
    }

    public function search(Request $request)
    {
      $categories = Category::whereRaw("name @@ plainto_tsquery('" . $request->search . "')")->get();
      
      return view('pages.categories', ['categories' => $categories]);
    }
}