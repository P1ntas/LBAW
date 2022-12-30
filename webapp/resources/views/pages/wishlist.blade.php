@extends('layouts.app')

@section('title', 'Wishlist')

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
