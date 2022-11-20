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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed'
        ]);

        if ($validator->fails()) {
            // error
            return $validator;
        }

        if (isset($data['user_address'])) {
            $validator = Validator::make($data, [
                'user_address' => 'string|min:8|max:255'
            ]);

            if ($validator->fails()) {
                // error
                return $validator;
            }
        }

        if (isset($data['phone'])) {
            $validator = Validator::make($data, [
                'phone' => 'regex:/^[1-9][1-9][1-9][1-9][1-9][1-9][1-9][1-9][1-9]$/'
            ]);

            if ($validator->fails()) {
                // error
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
