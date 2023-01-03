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
<h1>{{ $user->name }}</h1>
<div id="editWrapper">
    <img src="{{ URL::asset('images/avatar.jpg') }}" id="userPic" alt="userPicture">
</div>
<div class="profileWrapper1">
    @if ($user->isBlocked())
        <p>[This account is blocked]</p>
    @endif
    <p>Email: <span>{{ $user->email }}</span></p> 
    <p>Address: <span>{{ $user->user_address }}</span></p>
    @if (!empty($user->phone))
        <p>Phone Number: <span>{{ $user->phone }}</span></p>
    @endif
</div>
@endsection