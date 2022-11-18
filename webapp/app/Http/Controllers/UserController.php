<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Flash;

use App\Models\User;

class UserController extends Controller
{
    public function show($id)
    {
        $user = User::find($id);

        if (empty($user)) {
            Flash::error('User not found');
            return redirect('/');
        }

        return view('pages.user', ['user' => $user]);
    }

    public function list()
    {
        $users = User::all();

        if (empty($users)) {
            Flash::error('No users');
            return redirect('/');
        }

        return view('pages.users', ['users' => $users]);
    }

    public function delete(Request $request, $id)
    {
        $user = User::find($id);

        if (empty($user)) {
            Flash::error('User not found');
            return redirect('/');
        }

        $user->delete();
        return $user;
    }
}
