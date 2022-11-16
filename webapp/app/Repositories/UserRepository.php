<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'username',
        'email',
        'user_password',
        'user_address',
        'phone',
        'blocked'
    ];

    public function model()
    {
        return User::class;
    }
}
