<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use App\Models\FAQ;

class StaticController extends Controller
{
  public function index()
  {
    return view('pages.home');
  }

  public function about() {
    return view('pages.about');
  }

  public function services() {
    return view('pages.services');
  }

  public function faq() {
    
    $faqs = FAQ::all();

    return view('pages.faq', ['faqs' => $faqs]);

  }

  public function contacts() {
    return view('pages.contacts');
  }
}
