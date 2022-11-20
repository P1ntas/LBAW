@extends('layouts.app')

@section('title', 'Books')

@section('content')

<section id="books">
  <label for="search">Search</label>
  <form method="POST" action="/books/search">
    {{ csrf_field() }}
    <input type="text" name="search" placeholder="Search for a book">
  </form>
  @each('partials.book', $books, 'book')
</section>

@endsection
