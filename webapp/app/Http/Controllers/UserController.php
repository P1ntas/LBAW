<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\User;

class UserController extends Controller
{
    public function show($id)
    {
        $user = User::find($id);

        if (empty($user)) {
            return redirect('/');
        }

        if ($user->isAdmin()) {
            return view('pages.admin', ['admin' => $user]);
        }

        return view('pages.user', ['user' => $user]);
    }

    public function list()
    {
        $users = User::where('admin_perms', FALSE)->get();;

        if (empty($users)) {
            // to do
            return redirect('/');
        }

        return view('pages.users', ['users' => $users]);
    }

    public function edit($id)
    {
        $user = User::find($id);

        if (empty($user)) {
            // to do
            return redirect('/');
        }

        if ($user->isAdmin()) {
            return view('pages.edit_admin', ['admin' => $user]);
        }

        return view('pages.edit_user', ['user' => $user]);
    }

    public function update(Request $request, $id) {
        $user = User::find($id);

        if (empty($user)) {
            return redirect('/');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'email' => [Rule::unique('users')->ignore($user->id), 'string', 'email', 'max:255'],
            'user_address' => 'string|min:8|max:255',
            'phone' => 'regex:/^[1-9][1-9][1-9][1-9][1-9][1-9][1-9][1-9][1-9]$/'
        ]);

        if ($validator->fails()) {
            return redirect('/');
        }

        if ($request->password != $request->password_confirmation) {
            return redirect('/');
        }

        if (isset($request->password)) {
            $validator = Validator::make($request->all(), [
                'password' => 'string|min:3'
            ]);
    
            if ($validator->fails()) {
                return redirect('/');
            }

            if ($request->password == $request->password_confirmation) {
                $user->password = bcrypt($request->password);
            }
        }

        $user->id = $id;
        $user->name = $request->name;
        $user->email = $request->email;

        if (isset($request->user_address)) {
            $user->user_address = $request->user_address;
        }
        else {
            $user->user_address = null;
        }

        if (isset($request->user_phone)) {
            $user->phone = $request->phone;
        }
        else {
            $user->phone = null;
        }

        if (isset($request->blocked)) {
            $user->blocked = $request->blocked;
        }
        else {
            $user->blocked = $user->blocked;
        }

        $user->save();
        return redirect('/');
    }

    public function delete(Request $request, $id)
    {
        $user = User::find($id);

        if (empty($user)) {
            return redirect('/');
        }

        $user->delete();
        return $user;
    }

    public function shoppingCart($id) {
        $books = User::find($id)->cart()->get();

        return view('pages.cart', ['books' => $books]);
    }

    public function manageCart(Request $request, $id)
    {
        $user = User::find($id);

        if (empty($user)) {
            // to do
            return redirect('/');
        }

        $user->cart()->detach($request->book_id);
        return redirect('/');
    }

    public function clearCart(Request $request, $id)
    {
        $user = User::find($id);

        if (empty($user)) {
            // to do
            return redirect('/');
        }

        $user->cart()->detach();
        return redirect('/');
    }

    public function addToCart(Request $request, $id) {
        $user = User::find($request->user_id);
  
        if (empty($user)) {
          // to do
          return redirect('/');
        }
  
        $user->cart()->attach($id);
        return redirect('/');
    }

    public function checkoutInfo($id)
    {
        $books = User::find($id)->cart()->get();

        return view('pages.checkout', ['books' => $books]);
    }

    public function getCartBooks($id) {
        $books = User::find($id)->cart()->get();
        
        return $books;
    }
}
