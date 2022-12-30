<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

use App\Models\Delivery;

class DeliveryController extends Controller
{
    public function create(Request $request, $id)
    {
      $delivery = new Delivery();

      $delivery->arrival = Carbon::now(); // change to a week after
      $delivery->delivery_address = $request->delivery_address;
      $delivery->cost = $request->cost;
      $delivery->purchase_id = $id;
      $delivery->save();

      return $delivery;
    }

    public function delete($id) {
      $delivery = Delivery::find($id);
      $delivery->delete();
      
      return $delivery;
    }
}
