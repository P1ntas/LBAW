@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')

<div class="forIcons">
    <p class="lTitle">Shopping Cart</p>
    <iconify-icon icon="material-symbols:shopping-cart-outline-rounded" class="try1"></iconify-icon>
</div>
<div id="pWrapper">
    @each('partials.cart_book', $books, 'book')
</div>
{{ $books->links() }}
@if (count($books) > 0)
    <p id="deliveryCost">Delivery cost: 1.50 €</p>
    <div id="userWrapper">
        @php ($final_cost = 1.50)
        @foreach ($books as $book)
            @php ($final_cost += $book->price)
        @endforeach
        <p id="finalCost">Final cost: <span>{{ $final_cost }} €</span></p>
    </div>
    <div id="cButtons">
        <form method="GET" action="/users/{{ Auth::user()->id }}/cart/checkout">
            @csrf
            <button type="submit" id="edit_buttonC" class="edit_button"
            onclick="return confirm('Do you confirm this purchase?');">Checkout</button> 
        </form>
        <form method="POST" action="/users/{{ Auth::user()->id }}/cart/clear">
            @csrf
            @method('DELETE')
            <button type="submit" id="delete_buttonC" class="edit_button"
            onclick="return confirm('Are you sure you want to clear all items?');">Clear cart</button>
        </form>
    </div>
@endif

@endsection
