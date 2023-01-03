<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

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

        $purchases = Purchase::where('user_id', $id)->simplePaginate(8);

        return view('pages.purchases', ['purchases' => $purchases]);
    }

    public function cancelOrder($user_id, $purchase_id) {
        $user = User::find($user_id);
  
        if (empty($user)) {
            Session::flash('notification', 'User not found!');
            Session::flash('notification_type', 'error');

            return redirect()->back();
        }

        try {
            $this->authorize('cancelOrder', $user);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return redirect()->back();
        }

        $purchase = Purchase::find($purchase_id);

        if (empty($purchase)) {
            Session::flash('notification', 'Purchase not found!');
            Session::flash('notification_type', 'error');

            return redirect()->back();
        }

        $purchase->delete();

        Session::flash('notification', 'Your order has been canceled.');
        Session::flash('notification_type', 'success');
  
        return redirect()->action('PurchaseController@list', ['id' => $user_id]);
    }

    public function create($id) {
        $purchase = new Purchase();

        $purchase->user_id = $id;
        $purchase->state_purchase = 'Received';
        $purchase->save();

        return $purchase;
    }

    private function purchaseBooks($purchase, $books) {
        foreach ($books as $book) {
            $purchase->books()->attach($book->id);
        }
    }
    
    public function checkout($id) {
        try {
            $user = User::find($id);
    
            if (empty($user)) {
                Session::flash('notification', 'User not found!');
                Session::flash('notification_type', 'error');

                return redirect()->back();
            }

            try {
                $this->authorize('checkout', $user);
            } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
                return redirect()->back();
            }
        
            $books = app('App\Http\Controllers\UserController')->getCartBooks($id);
            $purchase = $this->create($id);
            $delivery = app('App\Http\Controllers\DeliveryController')->create($purchase->id);

            $this->purchaseBooks($purchase, $books);

            Session::flash('notification', 'Payment approved.');
            Session::flash('notification_type', 'success');

            return redirect()->action('UserController@shoppingCart', ['id' => $id]);
        }
        catch (\Exception $e) {
            if ($e->getMessage() == 'Blocked users cannot purchase books.') {
                Session::flash('notification', 'You cannot purchase books because you are blocked.');
                Session::flash('notification_type', 'error');
    
                return redirect()->back();
            } 
            else {
                return redirect()->back();
            }
        }
    }

    public function updateStatus(Request $request, $user_id, $purchase_id) {
        $request->replace(array_map(function($value) {
            return is_string($value) ? strip_tags($value) : $value;
        }, $request->all()));
        
        $user = User::find($user_id);
  
        if (empty($user)) {
            Session::flash('notification', 'User not found!');
            Session::flash('notification_type', 'error');

            return redirect()->back();
        }

        try {
            $this->authorize('status', $user);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return redirect()->back();
        }

        $purchase = Purchase::find($purchase_id);
        
        if (empty($purchase)) {
            Session::flash('notification', 'Purchase not found!');
            Session::flash('notification_type', 'error');

            return redirect()->back();
        }

        $validator = Validator::make($request->all(), [
                'status' => 'in:Received,Dispatched,Delivered',
            ], 
            [
                'status.in' => 'The selected status is not valid.'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $purchase->state_purchase = $request->status;
        $purchase->save();

        $notification = app('App\Http\Controllers\NotificationController')->generate(
            'Your purchase was now ' . $purchase->state_purchase,
            $user_id
        );
  
        return redirect()->back();
    }
}
