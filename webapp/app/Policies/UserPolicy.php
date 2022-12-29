<?php

namespace App\Policies;

use App\Models\User;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    use HandlesAuthorization;

    public function show(User $authUser, User $viewedUser)
    {
      return $authUser->id == $viewedUser->id;
    }
}
