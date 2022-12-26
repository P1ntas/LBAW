@extends('layouts.app')

@section('title', 'Books')

@section('content')

<section id="books">
  <label for="search">Search</label>
  <form method="POST" action="/api/books/search">
    {{ csrf_field() }}
    <input type="text" name="search" placeholder="Search for a book">
  </form>
  @if (Auth::user()->isAdmin())
    <a href="/books/add">Add a new book</a>
  @endif
  @each('partials.book', $books, 'book')
</section>

@endsection
