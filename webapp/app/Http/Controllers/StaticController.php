<?php

namespace App\Http\Controllers;

use App\Models\FAQ;

class StaticController extends Controller
{
  public function home() {
    return view('pages.home');
  }

  public function about() {
    return view('pages.about');
  }

  public function contacts() {
    return view('pages.contacts');
  }

  public function faq() {
    $faqs = FAQ::all();

    return view('pages.faq', ['faqs' => $faqs]);
  }
}
