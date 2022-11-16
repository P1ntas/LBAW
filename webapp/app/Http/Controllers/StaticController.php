<?php

namespace App\Http\Controllers;

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
    return view('pages.faq');
  }

  public function contact() {
    return view('pages.contact');
  }
}
