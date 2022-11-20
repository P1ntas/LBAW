@extends('layouts.app')

@section('title', 'Off The Shelf')

@section('content')

<div class="container">
    <a href="{{ url('books') }}">Books</a>
    @auth
        @if (Auth::user()->isAdmin())
            <a href="{{ url('users') }}">Users</a>
        @else
            <a href="/users/{{Auth::user()->id}}/purchases">Purchase History</a>
        @endif
    @endauth
</div>

@endsection