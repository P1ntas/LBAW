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
<div class="homePage">
    <div id="books">
        <span>Books</span>
        @if (Auth::check() && Auth::user()->isAdmin())
            <span>
                <a href="/books/add"><i class="fa-regular fa-plus"></i> Book</a>
            </span>
        @endif
        <a href="/books"><span>View all >></span></a>
    </div>
    <div class="books">
        @each('partials.book', $books, 'book')
    </div>
    <div id="books">
        <span>Collections</span>
        <a href="/"><span class="pos">View all >></span></a>
    </div>
    <div class="books">
        <!-- collections -->
    </div>
</div>
@endsection