@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')

<section id="cart">
  <form method="GET" action="/api/users/{{Auth::user()->id}}/cart">
    <input type="submit" value="Clear cart">
  </form>
  @each('partials.cart_book', $books, 'book')
</section>

@endsection
