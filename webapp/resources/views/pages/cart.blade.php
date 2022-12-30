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
<div id="cButtons">
    <form method="POST" action="/users/{{ Auth::user()->id }}/cart/clear">
        @csrf
        @method('DELETE')
        <button type="submit" id="delete_buttonC" class="edit_button"
        onclick="return confirm('Are you sure you want to clear all items?');">Clear cart</button>
    </form>
</div>


@endsection
