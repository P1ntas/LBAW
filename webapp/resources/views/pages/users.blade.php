@extends('layouts.app')

@section('title', 'Users')

@section('content')

<section id="users">
  @each('partials.user', $users, 'user')
</section>

@endsection
