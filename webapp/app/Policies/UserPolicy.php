<?php

namespace App\Policies;

use App\Models\User;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    use HandlesAuthorization;

    public function show(User $authUser, User $user) {
      if ($authUser->id == $user->id) {
        return true;
      }

      return $authUser->isAdmin() && !$user->isAdmin();
    }

    public function update(User $authUser, User $user) {
      if ($authUser->id == $user->id) {
        return true;
      }

      return $authUser->isAdmin() && !$user->isAdmin();
    }

    public function delete(User $authUser, User $user) {
      if ($authUser->id == $user->id) {
        return true;
      }

      return $authUser->isAdmin() && !$user->isAdmin();
    }

    public function viewCart(User $authUser, User $user) {
      return !$authUser->isAdmin() && $authUser->id == $user->id;
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
      if ($authUser->id == $user->id) {
        return true;
      }

      return $authUser->isAdmin() && !$user->isAdmin();
    }

    public function cancelOrder(User $authUser, User $user) {
      return $authUser->id == $user->id;
    }

    public function viewWishlist(User $authUser, User $user) {
      return !$authUser->isAdmin() && $authUser->id == $user->id;
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

    public function removeReview(User $authUser, User $user) {
      if ($authUser->id == $user->id) {
        return true;
      }

      return $authUser->isAdmin() && !$user->isAdmin();
    }

    public function editReview(User $authUser, User $user) {
      return $authUser->id == $user->id;
    }

    public function list(User $authUser) {
      return $authUser->isAdmin();
    }

    public function block(User $authUser, User $user) {
      return $authUser->isAdmin() && !$user->isAdmin() && $authUser->id != $user->id;
    }

    public function status(User $authUser, User $user) {
      return $authUser->isAdmin() && !$user->isAdmin() && $authUser->id != $user->id;
    }

    public function addBook(User $authUser) {
      return $authUser->isAdmin();
    }

    public function editBook(User $authUser) {
      return $authUser->isAdmin();
    }

    public function deleteBook(User $authUser) {
      return $authUser->isAdmin();
    }

    public function deleteCategory(User $authUser) {
      return $authUser->isAdmin();
    }

    public function addCategory(User $authUser) {
      return $authUser->isAdmin();
    }

    public function editCategory(User $authUser) {
      return $authUser->isAdmin();
    }
}
