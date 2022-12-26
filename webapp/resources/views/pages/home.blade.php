@extends('layouts.app')

@section('title', 'Home')

@section('content')

<div class="container">
    <a href="/books">Books</a>
    @auth
        @if (Auth::user()->isAdmin())
            <a href="/users">Users</a>
        @else
            <a href="/users/{{Auth::user()->id}}/purchases">Purchases</a>
        @endif
    @endauth
</div>

@endsection