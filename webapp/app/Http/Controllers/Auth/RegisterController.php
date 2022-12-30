<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        $validator = Validator::make($data, [
            'email' => 'required|string|email|min:6|max:255|unique:users',
            'name' => 'required|string|min:6|max:255',
            'password' => 'required|string|min:6|confirmed',
            'user_address' => 'required|string|min:8|max:255'
        ]);

        if ($validator->fails()) {
            return $validator;
        }

        if (isset($data['phone'])) {
            $validator = Validator::make($data, [
                'phone' => 'regex:/^[1-9][1-9][1-9][1-9][1-9][1-9][1-9][1-9][1-9]$/'
            ]);

            if ($validator->fails()) {
                return $validator;
            }
        }

        return $validator;
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'user_address' => $data['user_address'],
            'phone' => $data['phone'],
            'blocked' => $data['blocked'],
            'admin_perms' => $data['admin_perms']
        ]);
    }
}
