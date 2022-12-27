<?php

namespace App\Http\Controllers;

class StaticController extends Controller
{
  public function home() {
    return view('pages.home');
  }

  public function about() {
    return view('pages.about');
  }

  public function faq() {
    $faqs = FAQ::all();

    return view('pages.faq', ['faqs' => $faqs]);
  }

  public function contacts() {
    return view('pages.contacts');
  }
}
