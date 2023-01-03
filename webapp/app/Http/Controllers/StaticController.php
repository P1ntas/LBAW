<?php

namespace App\Http\Controllers;

use App\Models\FAQ;
use App\Models\Book;
use App\Models\Collection;

class StaticController extends Controller
{
  public function home() {
    $books = Book::take(3)->get();
    $collections = Collection::take(3)->get();

    return view('pages.home', [
      'books' => $books,
      'collections' => $collections
    ]);
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
