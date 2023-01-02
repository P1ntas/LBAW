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
<div class="catWrapper">
    <span class="title">{{ $collection->name }}</span>
    <ul>
        @foreach ($collection->books as $book)
            <li><a href="/books/{{ $book->id }}">{{ $book->title }}</a></li>
        @endforeach
    </ul>
</div>
@endsection