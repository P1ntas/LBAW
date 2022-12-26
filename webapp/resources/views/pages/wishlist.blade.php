@extends('layouts.app')

@section('title', 'Wishlist')

@section('content')

<section id="wishlist">
  <form method="GET" action="/api/users/{{Auth::user()->id}}/wishlist/clear">
    <input type="submit" value="Clear wishlist">
  </form>
  @each('partials.wishlist_book', $books, 'book')
</section>

@endsection
