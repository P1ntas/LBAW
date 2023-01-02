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
<div class="booksWrapper">
    <form method="POST" action="/collections/search">
        @csrf
        <input id="userSearch" type="text" name="search" value="{{ old('search') }}" placeholder="Search for a collection">
    </form>
    <div class="books">
        @each('partials.collection', $collections, 'collection')
    </div>
</div>
{{ $collections->links() }}
@endsection