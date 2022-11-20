@extends('layouts.app')

@section('title', 'Checkout')

@section('content')

<section id="checkoutInfo">
  <form method="POST" action="/api/users/{{Auth::user()->id}}/cart/checkout">
    @each('partials.book', $books, 'book')

    <label for="delivery_address">Delivery Address</label>
    <input id="delivery_address" type="text" name="delivery_address">
    @if ($errors->has('delivery_address'))
    <span class="error">
        {{ $errors->first('delivery_address') }}
    </span>
    @endif

    <input type="hidden" name="state_purchase" value="Received">
    <input type="hidden" name="cost" value="1.50">

    <p>Delivery cost: 1.50 €</p>

    @php ($finalcost = 1.50)
    @foreach ($books as $book)
      @php ($finalcost += $book->price)
    @endforeach
    <p>Final cost: {{$finalcost}} €</p>

    <button type="submit">Checkout</button>
    <a href="/users/{{Auth::user()->id}}/cart">Cancel</a>
  </form>
</section>

@endsection