<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

use App\Models\Category;
use App\Models\User;

class CategoryController extends Controller
{
    public function list() {
        $categories = Category::simplePaginate(10);

        if ($categories->isEmpty()) {
            Session::flash('notification', 'Categories not found!');
            Session::flash('notification_type', 'error');

            return redirect('/');
        }

        return view('pages.categories', ['categories' => $categories]);
    }

    public function create(Request $request) {
        try {
            $this->authorize('addCategory', User::class);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return redirect()->back();
        }

        $validator = Validator::make($request->all(), [
                'name' => 'required|string|min:1|max:100|unique:category'
            ], 
            [
                'name.required' => 'The name field is required.',
                'name.string' => 'The name field must be a string.',
                'name.min' => 'The name field must have at least :min characters.',
                'name.max' => 'The name field can have at most :max characters.',
                'name.unique' => 'A category with the same name already exists.'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back();
        }

        $category = new Category();
        $category->name = $request->name;
        $category->save();

        return redirect()->action('CategoryController@list');
    }

    public function update(Request $request, $id) {
        $category = Category::find($id);

        if (empty($category)) {
            Session::flash('notification', 'Category not found!');
            Session::flash('notification_type', 'error');

            return redirect()->back();
        }

        try {
            $this->authorize('editCategory', User::class);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return redirect()->back();
        }

        $validator = Validator::make($request->all(), [
                'name' => 'required|string|min:1|max:100|unique:category'
            ], 
            [
                'name.required' => 'The name field is required.',
                'name.string' => 'The name field must be a string.',
                'name.min' => 'The name field must have at least :min characters.',
                'name.max' => 'The name field can have at most :max characters.',
                'name.unique' => 'A category with the same name already exists.'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back();
        }

        $category->name = $request->name;
        $category->save();

        return redirect()->action('CategoryController@list');
    }

    public function delete($id) {
        try {
            $this->authorize('deleteCategory', User::class);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return redirect()->back();
        }

        $category = Category::find($id);

        if (empty($category)) {
            Session::flash('notification', 'Category not found!');
            Session::flash('notification_type', 'error');

            return redirect()->back();
        }

        $category->delete();

        Session::flash('notification', 'This category has been deleted.');
        Session::flash('notification_type', 'success');
  
        return redirect()->action('CategoryController@list');
    }
}
