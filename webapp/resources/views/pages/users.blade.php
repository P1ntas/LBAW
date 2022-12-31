@extends('layouts.app')

@section('title', 'Users')

@section('content')

<div id="userWrapper">
    <form method="POST" action="/users/search">
        @csrf
        <input id="userSearch" type="text" name="search" placeholder="Search for an user">
    </form>
    <div id="pWrapper">
        @each('partials.user', $users, 'user')
    </div>
</div>
{{ $users->links() }}

@endsection
