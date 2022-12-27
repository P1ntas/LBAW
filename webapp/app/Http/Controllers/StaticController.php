<?php

namespace App\Http\Controllers;

class StaticController extends Controller
{
  public function home() {
    return view('pages.home');
  }
}
