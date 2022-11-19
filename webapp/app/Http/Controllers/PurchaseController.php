<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Purchase;

class PurchaseController extends Controller
{
    public function show($id)
    {
      $purchase = Purchase::find($id);

      if (empty($purchase)) {
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
        return redirect('/');
      }

      return view('pages.purchases', ['purchases' => $purchases]);
    }

    public function listByUser($id) {
        $purchases = Purchase::where('user_id', $id)->get();

        return view('pages.purchases', ['purchases' => $purchases]);
    }

    public function create(Request $request)
    {
      $purchase = new Purchase();

      // inputs fields
      $purchase->save();

      return $purchase;
    }

    public function delete(Request $request, $id)
    {
      $purchase = Purchase::find($id);

      if (empty($purchase)) {
        return redirect('/');
      }

      $purchase->delete();
      return $purchase;
    }
}
