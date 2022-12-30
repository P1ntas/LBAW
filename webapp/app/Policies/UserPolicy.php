<?php

namespace App\Policies;

use App\Models\User;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    use HandlesAuthorization;

    public function show(User $authUser, User $user) {
      return $authUser->id == $user->id;
    }

    public function update(User $authUser, User $user) {
      return $authUser->id == $user->id;
    }

    public function delete(User $authUser, User $user) {
      return $authUser->id == $user->id;
    }

    public function viewCart(User $authUser, User $user) {
      return $authUser->id == $user->id;
    }

    public function manageCart(User $authUser, User $user) {
      return $authUser->id == $user->id;
    }

    public function clearCart(User $authUser, User $user) {
      return $authUser->id == $user->id;
    }

    public function addToCart(User $authUser, User $user) {
      return $authUser->id == $user->id;
    }

    public function viewPurchases(User $authUser, User $user) {
      return $authUser->id == $user->id;
    }

    public function cancelOrder(User $authUser, User $user) {
      return $authUser->id == $user->id;
    }

    public function viewWishlist(User $authUser, User $user) {
      return $authUser->id == $user->id;
    }
  
    public function manageWishlist(User $authUser, User $user) {
      return $authUser->id == $user->id;
    }

    public function addToWishlist(User $authUser, User $user) {
      return $authUser->id == $user->id;
    }

    public function checkout(User $authUser, User $user) {
      return $authUser->id == $user->id;
    }

    public function review(User $authUser, User $user) {
      return $authUser->id == $user->id;
    }

    public function removeReview(User $authUser, User $user) {
      return $authUser->id == $user->id;
    }
}
