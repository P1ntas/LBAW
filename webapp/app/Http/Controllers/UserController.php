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
            // error
            return redirect('/');
        }

        if ($user->isAdmin()) {
            return view('pages.admin', ['admin' => $user]);
        }

        return view('pages.user', ['user' => $user]);
    }

    public function list()
    {
        $users = User::where('admin_perms', FALSE)->get();

        if (empty($users)) {
            // error
            return redirect('/');
        }

        $this->authorize('list', User::class);
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
            // error
            return redirect('/');
        }

        //$this->authorize('update', User::class);

        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'email' => [Rule::unique('users')->ignore($user->id), 'string', 'email', 'max:255'],
            'phone' => 'regex:/^[1-9][1-9][1-9][1-9][1-9][1-9][1-9][1-9][1-9]$/'
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

        $this->authorize('viewCart', User::class);
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
        return redirect()->back();
    }

    public function clearCart($id)
    {
        $user = User::find($id);

        if (empty($user)) {
            // to do
            return redirect('/');
        }

        $user->cart()->detach();
        return redirect()->back();
    }

    public function addToCart(Request $request, $id) {
        $user = User::find($request->user_id);
  
        if (empty($user)) {
          // to do
          return redirect('/');
        }
  
        $user->cart()->attach($id);
        return redirect()->back();
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

    public function search(Request $request)
    {
      $users = User::whereRaw("name @@ plainto_tsquery('" . $request->search . "')")->get();
      
      return view('pages.users', ['users' => $users]);
    }
}
