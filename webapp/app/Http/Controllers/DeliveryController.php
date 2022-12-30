<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

use App\Models\Delivery;

class DeliveryController extends Controller
{
  public function create($id) {
    $delivery = new Delivery();

    $delivery->arrival = Carbon::now(); // change to a week after
    $delivery->delivery_address = Auth::user()->user_address;
    $delivery->cost = 1.50;
    $delivery->purchase_id = $id;
    $delivery->save();

    return $delivery;
  }
}
