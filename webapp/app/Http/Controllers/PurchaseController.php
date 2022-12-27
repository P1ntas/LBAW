<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Purchase;
use App\Models\Delivery;

class PurchaseController extends Controller
{
    public function show($id)
    {
      $purchase = Purchase::find($id);

      if (empty($purchase)) {
        // error
        return redirect('/');
      }

      return view('pages.purchase', [
        'purchase' => $purchase, 
        'user' => $purchase->user, 
        'books' => $purchase->books,
        'delivery' => $purchase->delivery
      ]);
    }

    public function list()
    {
      $purchases = Purchase::all();

      if (empty($purchases)) {
        // error
        return redirect('/');
      }

      return view('pages.purchases', ['purchases' => $purchases]);
    }

    public function listByUser($id)
    {
        $purchases = Purchase::where('user_id', $id)->get();

        return view('pages.purchases', ['purchases' => $purchases]);
    }

    public function create(Request $request, $id)
    {
      $purchase = new Purchase();

      $purchase->user_id = $id;
      $purchase->state_purchase = $request->state_purchase;
      $purchase->save();

      return $purchase;
    }

    private function purchaseBooks($purchase, $books)
    {
      foreach ($books as $book) {
        $purchase->books()->attach($book->id);
      }
    }

    public function checkout(Request $request, $id)
    {
      $purchase = $this->create($request, $id);
      $delivery = app('App\Http\Controllers\DeliveryController')->create($request, $purchase->id);
      $books = app('App\Http\Controllers\UserController')->getCartBooks($id);

      $this->purchaseBooks($purchase, $books);

      return redirect('/');
    }

    public function cancelOrder(Request $request, $id) {
      $purchase = Purchase::find($request->purchase_id);
      $purchase->delete();
      $delivery = app('App\Http\Controllers\DeliveryController')->delete($request, $id);

      return redirect('/');
    }

    public function updateStatus(Request $request, $id) {
      $purchase = Purchase::find($request->purchase_id);
      $purchase->state_purchase = $request->status;
      $purchase->save();

      return redirect()->back();
    }
}
