@extends('layouts.app')

@section('title', $admin->name)

@section('content')

<article class="admin" data-id="{{ $admin->id }}">
    <p>Name: {{ $admin->name }}</p>
    <p>Email: {{ $admin->email }}</p>
    <p>Address: {{ $admin->user_address }}</p>
    <p>Phone: {{ $admin->phone }}</p>
    <a href="/admins/{{ $admin->id }}/edit">Edit Profile</a>
</article>

@endsection
