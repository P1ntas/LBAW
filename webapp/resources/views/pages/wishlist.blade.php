@extends('layouts.app')

@section('notification')
@if (Session::has('notification'))
    <div class="notification {{ Session::get('notification_type') }}">
      {{ Session::get('notification') }}
    </div>
    <button class="close-button" type="button">X</button>
@endif
@endsection

@section('content')
<div class="forIcons">
    <p class="lTitle">Wishlist</p>
    <iconify-icon icon="mdi:cards-heart-outline" class="try1"></iconify-icon>
    </div>
<div id="pWrapper">
    @each('partials.wish_book', $books, 'book')
</div>
{{ $books->links() }}
@endsection