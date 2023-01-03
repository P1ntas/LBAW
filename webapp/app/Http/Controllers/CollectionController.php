<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

use App\Models\Collection;
use App\Models\User;
use App\Models\Book;

class CollectionController extends Controller
{
    public function list() {
        $collections = Collection::simplePaginate(8);

        if ($collections->isEmpty()) {
            Session::flash('notification', 'Collections not found!');
            Session::flash('notification_type', 'error');

            return redirect('/');
        }

        return view('pages.collections', ['collections' => $collections]);
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

        $results = Collection::whereRaw("name @@ plainto_tsquery('" . $request->search . "')")->simplePaginate(8);
        
        return view('pages.collections', ['collections' => $results]);
    }

    public function show($id) {
        $collection = Collection::find($id);

        if (empty($collection)) {
            Session::flash('notification', 'Collection not found!');
            Session::flash('notification_type', 'error');

            return redirect()->back();
        }

        return view('pages.collection', ['collection' => $collection]);
    }

    public function add() {
        $books = Book::all();
  
        if ($books->isEmpty()) {
            Session::flash('notification', 'Books not found!');
            Session::flash('notification_type', 'error');

            return redirect('/');
        }

        try {
            $this->authorize('addCollection', User::class);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return redirect()->back();
        }
  
        return view('pages.add_collection', ['books' => $books]);
    }

    public function create(Request $request) {
        $request->replace(array_map(function($value) {
            return is_string($value) ? strip_tags($value) : $value;
        }, $request->all()));

        try {
            $this->authorize('addCollection', User::class);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return redirect()->back();
        }

        $validator = Validator::make($request->all(), [
                'name' => 'required|escape_html|string|min:1|max:100'
            ], 
            [
                'name.required' => 'The name field is required.',
                'name.escape_html' => 'The name field may not contain any special characters.',
                'name.string' => 'The name field must be a string.',
                'name.min' => 'The name field must have at least :min characters.',
                'name.max' => 'The name field can have at most :max characters.'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $collection = new Collection();
        $collection->name = $request->name;
        $collection->save();

        return redirect()->action('CollectionController@list');
    }

    public function edit($id) {
        $collection = Collection::find($id);

        if (empty($collection)) {
            Session::flash('notification', 'Collection not found!');
            Session::flash('notification_type', 'error');

            return redirect()->back();
        }

        $books = Book::all();
  
        if ($books->isEmpty()) {
            Session::flash('notification', 'Books not found!');
            Session::flash('notification_type', 'error');

            return redirect('/');
        }

        try {
            $this->authorize('editCollection', User::class);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return redirect()->back();
        }
  
        return view('pages.edit_collection', [
            'collection' => $collection,
            'books' => $books
        ]);
    }

    public function update(Request $request, $id) {
        $request->replace(array_map(function($value) {
            return is_string($value) ? strip_tags($value) : $value;
        }, $request->all()));
        
        $collection = Collection::find($id);

        if (empty($collection)) {
            Session::flash('notification', 'Collection not found!');
            Session::flash('notification_type', 'error');

            return redirect()->back();
        }

        try {
            $this->authorize('editCollection', User::class);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return redirect()->back();
        }

        $validator = Validator::make($request->all(), [
                'name' => 'required|escape_html|string|min:1|max:100'
            ], 
            [
                'name.required' => 'The name field is required.',
                'name.escape_html' => 'The name field may not contain any special characters.',
                'name.string' => 'The name field must be a string.',
                'name.min' => 'The name field must have at least :min characters.',
                'name.max' => 'The name field can have at most :max characters.'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $collection->name = $request->name;
        $collection->save();

        return redirect()->action('CollectionController@list');
    }

    public function delete($id) {
        try {
            $this->authorize('deleteCollection', User::class);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return redirect()->back();
        }

        $collection = Collection::find($id);

        if (empty($collection)) {
            Session::flash('notification', 'Collection not found!');
            Session::flash('notification_type', 'error');

            return redirect()->back();
        }

        $collection->delete();

        Session::flash('notification', 'This collection has been deleted.');
        Session::flash('notification_type', 'success');
  
        return redirect()->action('CollectionController@list');
    }
}
