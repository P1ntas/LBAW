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

    public function show($id)
    {
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

        return view('pages.user', ['user' => $user]);
    }

    public function edit($id)
    {
        $user = User::find($id);

        if (empty($user)) {
            Session::flash('notification', 'User not found!');
            Session::flash('notification_type', 'error');

            return redirect()->back();
        }

        try {
            $this->authorize('edit', $user);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return redirect()->back();
        }

        return view('pages.edit_user', ['user' => $user]);
    }

    public function update(Request $request, $id) {
        $user = User::find($id);

        if (empty($user)) {
            Session::flash('notification', 'User not found!');
            Session::flash('notification_type', 'error');

            return redirect()->back();
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:6|max:255',
            'email' => [Rule::unique('users')->ignore($user->id), 'required', 'string', 'email', 'min:6', 'max:255'],
            'user_address' => 'required|string|min:8|max:255'
        ]);

        if ($validator->fails()) {
            Session::flash('notification', 'Invalid inputs!');
            Session::flash('notification_type', 'error');

            return redirect()->action('UserController@edit', ['id' => $id]);
        }

        if (isset($request->phone)) {
            $validator = Validator::make($request->all(), [
                'phone' => 'regex:/^[1-9][1-9][1-9][1-9][1-9][1-9][1-9][1-9][1-9]$/'
            ]);

            if ($validator->fails()) {
                Session::flash('notification', 'Invalid inputs!');
                Session::flash('notification_type', 'error');
    
                return redirect()->action('UserController@edit', ['id' => $id]);
            }
        }

        if ($request->password != $request->password_confirmation) {
            Session::flash('notification', 'Passwords do not match!');
            Session::flash('notification_type', 'error');

            return redirect()->action('UserController@edit', ['id' => $id]);
        }

        if (isset($request->password)) {
            $validator = Validator::make($request->all(), [
                'password' => 'string|min:6'
            ]);
    
            if ($validator->fails()) {
                Session::flash('notification', 'Invalid password!');
                Session::flash('notification_type', 'error');
    
                return redirect()->action('UserController@edit', ['id' => $id]);
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
        $user->save();

        return redirect()->action('UserController@show', ['id' => $id]);
    }
}