@extends('layouts.app')

@section('title', 'Users')

@section('content')

<section id="users">
  <label for="search">Search</label>
  <form method="POST" action="/api/users/search">
    {{ csrf_field() }}
    <input type="text" name="search" placeholder="Search for an user">
  </form>
  @each('partials.user', $users, 'user')
</section>

@endsection
