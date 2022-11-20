<?php

namespace App\Policies;

use App\Models\User;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    use HandlesAuthorization;

    public function list(User $user)
    {
      return Auth::user()->isAdmin();
    }

    public function update(User $user)
    {
      return Auth::user()->id == $user->id || Auth::user()->isAdmin();
    }

    public function viewCart(User $user)
    {
      return Auth::user()->id == $user->id;
    }
}
