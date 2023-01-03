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
<h1>{{ $admin->name }}</h1>
<div id="editWrapper">
    <img src="{{ URL::asset('images/avatar.jpg') }}" id="userPic" alt="userPicture">
</div>
<div class="profileWrapper1">
    <p>Email: <span>{{ $admin->email }}</span></p> 
    <p>Address: <span>{{ $admin->user_address }}</span></p>
    @if (!empty($admin->phone))
        <p>Phone Number: <span>{{ $admin->phone }}</span></p>
    @endif
</div>
@endsection