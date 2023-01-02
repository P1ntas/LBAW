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
<div id="userWrapper">
    <form method="POST" action="/users/search">
        @csrf
        <input id="userSearch" type="text" name="search" value="{{ old('search') }}" placeholder="Search for an user">
    </form>
    <div id="pWrapper">
        @each('partials.user', $users, 'user')
    </div>
</div>
{{ $users->links() }}
@endsection