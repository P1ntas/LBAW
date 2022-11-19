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

        return view('pages.user', ['user' => $user]);
    }

    public function list()
    {
        $users = User::all();

        if (empty($users)) {
            return redirect('/');
        }

        return view('pages.users', ['users' => $users]);
    }

    public function edit($id)
    {
        $user = User::find($id);

        if (empty($user)) {
            return redirect('/');
        }

        if ($user->id != Auth::id()) {
            return view('pages.user', ['user' => Auth::user()]);
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

        if (isset($request->user_address)) {
            $user->phone = $request->phone;
        }
        else {
            $user->phone = null;
        }

        $user->blocked = $request->blocked;

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
}
