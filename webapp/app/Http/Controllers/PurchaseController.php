<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\Purchase;
use App\Models\Delivery;
use App\Models\User;

class PurchaseController extends Controller
{
    public function list($id)
    {
        $user = User::find($id);
  
        if (empty($user)) {
            Session::flash('notification', 'User not found!');
            Session::flash('notification_type', 'error');

            return redirect()->back();
        }

        try {
            $this->authorize('viewPurchases', $user);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return redirect()->back();
        }

        $purchases = Purchase::where('user_id', $id)->get();

        return view('pages.purchases', ['purchases' => $purchases]);
    }

}
