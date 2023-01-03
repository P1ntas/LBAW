<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

use App\Models\User;

class UserController extends Controller
{
    public function forgot() {
        return view('auth.forgot-password');
    }

    public function forgotPassword(Request $request) {
        $request->replace(array_map(function($value) {
            return is_string($value) ? strip_tags($value) : $value;
        }, $request->all()));

        $request->validate(['email' => 'required|email']);
     
        $status = Password::sendResetLink(
            $request->only('email')
        );
     
        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function reset($token) {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request) {
        $request->replace(array_map(function($value) {
            return is_string($value) ? strip_tags($value) : $value;
        }, $request->all()));

        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);
     
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
     
                $user->save();
     
                event(new PasswordReset($user));
            }
        );
     
        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    public function show($id) {
        $user = User::find($id);

        if (empty($user)) {
            Session::flash('notification', 'User not found!');
            Session::flash('notification_type', 'error');

            return redirect()->back();
        }

        try {
            $this->authorize('show', $user);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return redirect()->back();
        }

        if ($user->isAdmin()) {
            return view('pages.admin', ['admin' => $user]);
        }

        return view('pages.user', ['user' => $user]);
    }

    public function edit($id) {
        $user = User::find($id);

        if (empty($user)) {
            Session::flash('notification', 'User not found!');
            Session::flash('notification_type', 'error');

            return redirect()->back();
        }

        try {
            $this->authorize('update', $user);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return redirect()->back();
        }

        if ($user->isAdmin()) {
            return view('pages.edit_admin', ['admin' => $user]);
        }

        return view('pages.edit_user', ['user' => $user]);
    }

    public function update(Request $request, $id) {
        $request->replace(array_map(function($value) {
            return is_string($value) ? strip_tags($value) : $value;
        }, $request->all()));

        $user = User::find($id);

        if (empty($user)) {
            Session::flash('notification', 'User not found!');
            Session::flash('notification_type', 'error');

            return redirect()->back();
        }

        try {
            $this->authorize('update', $user);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return redirect()->back();
        }

        $validator = Validator::make($request->all(), [
                'name' => 'required|escape_html|string|min:6|max:255',
                'email' => [Rule::unique('users')->ignore($user->id), 'required', 'escape_html', 'string', 'email', 'min:6', 'max:255'],
                'user_address' => 'required|escape_html|string|min:8|max:255'
            ], 
            [
                'name.required' => 'Please enter a name',
                'name.escape_html' => 'The name field may not contain any special characters.',
                'name.string' => 'The name must be a string',
                'name.min' => 'The name must be at least 6 characters',
                'name.max' => 'The name must be no more than 255 characters',
                'email.unique' => 'This email is already in use',
                'email.required' => 'Please enter an email',
                'email.escape_html' => 'The email field may not contain any special characters.',
                'email.string' => 'The email must be a string',
                'email.email' => 'The email must be a valid email address',
                'email.min' => 'The email must be at least 6 characters',
                'email.max' => 'The email must be no more than 255 characters',
                'user_address.required' => 'Please enter an address',
                'user_address.escape_html' => 'The address field may not contain any special characters.',
                'user_address.string' => 'The address must be a string',
                'user_address.min' => 'The address must be at least 8 characters',
                'user_address.max' => 'The address must be no more than 255 characters'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        if (isset($request->phone)) {
            $validator = Validator::make($request->all(), [
                    'phone' => 'regex:/^[1-9][1-9][1-9][1-9][1-9][1-9][1-9][1-9][1-9]$/'
                ], 
                [
                    'phone.regex' => 'The phone number must be a 9-digit number with no spaces or special characters'
                ]
            );

            if ($validator->fails()) {
                return redirect()->back();
            }
        }

        if (isset($request->blocked)) {
            $validator = Validator::make($request->all(), [
                'blocked' => 'in:TRUE,FALSE'
            ]);

            if ($validator->fails()) {
                return redirect()->back();
            }

            try {
                $this->authorize('block', $user);
            } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
                return redirect()->back();
            }
        }

        if (isset($request->password)) {
            $validator = Validator::make($request->all(), [
                    'password' => 'string|escape_html|min:6|same:password_confirmation',
                    'password_confirmation' => 'string|min:6'
                ], 
                [
                    'password.min' => 'The password must be at least 6 characters',
                    'password.escape_html' => 'The password field may not contain any special characters.',
                    'password.same' => 'The passwords must match'
                ]
            );
    
            if ($validator->fails()) {
                return redirect()->back();
            }

            if ($request->password == $request->password_confirmation) {
                $user->password = bcrypt($request->password);
            }
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->user_address = $request->user_address;
        if (isset($request->phone)) {
            $user->phone = $request->phone;
        }
        if (isset($request->blocked)) {
            $user->blocked = $request->blocked;
        }
        $user->save();

        if (Auth::user()->isAdmin() && !$user->isAdmin()) {
            return redirect()->route('pages.user', ['id' => $id]);
        }

        return redirect()->action('UserController@show', ['id' => $id]);
    }

    public function delete($id) {
        $user = User::find($id);

        if (empty($user)) {
            Session::flash('notification', 'User not found!');
            Session::flash('notification_type', 'error');

            return redirect()->back();
        }

        try {
            $this->authorize('delete', $user);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return redirect()->back();
        }

        $user->name = '[DELETED]';
        $user->password = bcrypt(Str::random(20));
        $user->save();

        Session::flash('notification', 'This account has been deleted.');
        Session::flash('notification_type', 'success');

        if (Auth::user()->isAdmin() && !$user->isAdmin()) {
            return redirect()->action('UserController@list');
        }

        return redirect()->action('Auth\LoginController@logout');
    }

    public function shoppingCart($id) {
        $user = User::find($id);

        if (empty($user)) {
            Session::flash('notification', 'User not found!');
            Session::flash('notification_type', 'error');

            return redirect()->back();
        }

        try {
            $this->authorize('viewCart', $user);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return redirect()->back();
        }

        $books = $user->cart()->simplePaginate(8);

        return view('pages.cart', ['books' => $books]);
    }

    public function manageCart($user_id, $book_id) {
        $user = User::find($user_id);

        if (empty($user)) {
            Session::flash('notification', 'User not found!');
            Session::flash('notification_type', 'error');

            return redirect()->back();
        }

        try {
            $this->authorize('manageCart', $user);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return redirect()->back();
        }

        $user->cart()->detach($book_id);

        return redirect()->action('UserController@shoppingCart', ['id' => $user_id]);
    }

    public function clearCart($id) {
        $user = User::find($id);

        if (empty($user)) {
            Session::flash('notification', 'User not found!');
            Session::flash('notification_type', 'error');

            return redirect()->back();
        }

        try {
            $this->authorize('clearCart', $user);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return redirect()->back();
        }

        $user->cart()->detach();

        return redirect()->action('UserController@shoppingCart', ['id' => $id]);
    }

    public function addToCart($book_id) {
        try {
            $user_id = Auth::user()->id;
            $user = User::find($user_id);
    
            if (empty($user)) {
                Session::flash('notification', 'User not found!');
                Session::flash('notification_type', 'error');

                return redirect()->back();
            }

            try {
                $this->authorize('addToCart', $user);
            } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
                return redirect()->back();
            }
    
            if ($user->cart()->where('book_id', $book_id)->exists()) {
                Session::flash('notification', 'This book is already in your cart!');
                Session::flash('notification_type', 'warning');

                return redirect()->back();
            }
            
            $user->cart()->attach($book_id);

            return redirect()->action('UserController@shoppingCart', ['id' => $user_id]);
        }
        catch (\Exception $e) {
            if ($e->getMessage() == 'This book is out of stock.') {
                Session::flash('notification', 'You cannot add this book to the cart (out of stock).');
                Session::flash('notification_type', 'error');
    
                return redirect()->back();
            } 
            else {
                return redirect()->back();
            }
        }
    }

    public function wishlist($id) {
        $user = User::find($id);

        if (empty($user)) {
            Session::flash('notification', 'User not found!');
            Session::flash('notification_type', 'error');

            return redirect()->back();
        }

        try {
            $this->authorize('viewWishlist', $user);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return redirect()->back();
        }

        $books = User::find($id)->wishlist()->simplePaginate(8);

        return view('pages.wishlist', ['books' => $books]);
    }

    public function manageWishlist($user_id, $book_id) {
        $user = User::find($user_id);

        if (empty($user)) {
            Session::flash('notification', 'User not found!');
            Session::flash('notification_type', 'error');

            return redirect()->back();
        }

        try {
            $this->authorize('manageWishlist', $user);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return redirect()->back();
        }

        $user->wishlist()->detach($book_id);

        return redirect()->action('UserController@wishlist', ['id' => $user_id]);
    }

    public function addToWishlist($book_id) {
        $user_id = Auth::user()->id;
        $user = User::find($user_id);
  
        if (empty($user)) {
            Session::flash('notification', 'User not found!');
            Session::flash('notification_type', 'error');

            return redirect()->back();
        }

        try {
            $this->authorize('addToWishlist', $user);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return redirect()->back();
        }
  
        if ($user->wishlist()->where('book_id', $book_id)->exists()) {
            Session::flash('notification', 'This book is already in your wishlist!');
            Session::flash('notification_type', 'warning');

            return redirect()->back();
        }
        
        $user->wishlist()->attach($book_id);

        return redirect()->action('UserController@wishlist', ['id' => $user_id]);
    }

    public function getCartBooks($id) {
        $books = User::find($id)->cart()->get();
        
        if (empty($books)) {
            Session::flash('notification', 'Your order has no items!');
            Session::flash('notification_type', 'warning');

            return redirect()->back();
        }

        return $books;
    }

    public function getUser($id) {
        return User::find($id);
    }

    public function list() {
        $users = User::where('admin_perms', FALSE)->simplePaginate(8);

        if ($users->isEmpty()) {
            Session::flash('notification', 'Users not found!');
            Session::flash('notification_type', 'error');

            return redirect('/');
        }

        try {
            $this->authorize('list', User::class);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return redirect()->back();
        }

        return view('pages.users', ['users' => $users]);
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

        $results = User::whereRaw("name @@ plainto_tsquery('" . $request->search . "')")->simplePaginate(8);

        try {
            $this->authorize('list', User::class);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return redirect()->back();
        }
        
        return view('pages.users', ['users' => $results]);
    }
}