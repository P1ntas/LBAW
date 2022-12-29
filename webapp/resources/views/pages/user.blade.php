@extends('layouts.app')

@section('title', $user->name)

@section('content')

<h1>{{ $user->name }}</h1>
<div id="editWrapper">
    <!-- user_photo -->
</div>
<div class="profileWrapper1">
    <p>Email: <span>{{ $user->email }}</span></p> 
    <p>Address: <span>{{ $user->user_address }}</span></p>
    @if (!empty($user->phone))
        <p>Phone Number: <span>{{ $user->phone }}</span></p>
    @endif
</div>

@endsection
