@extends('layouts.app')

@section('name', 'Users')

@section('content')

<section id="users">
  @each('partials.user', $users, 'user')
</section>

@endsection
