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
<h1>Edit Profile</h1>
<div id="editWrapper">
    <img src="{{ URL::asset('images/avatar.jpg') }}" id="userPic" alt="userPicture">
</div>
<form id="fedit" method="POST" action="/admins/{{$admin->id}}/edit">
    @csrf
    @method('PUT')

    <input class="editor" type="text" name="name" value="{{$admin->name}}">
    @if ($errors->has('name'))
    <span class="error">
        {{ $errors->first('name') }}
    </span>
    @endif

    <input class="editor" type="email" name="email" value="{{$admin->email}}">
    @if ($errors->has('email'))
    <span class="error">
        {{ $errors->first('email') }}
    </span>
    @endif

    <input class="editor" type="password" name="password" placeholder="Insert your new password">
    @if ($errors->has('password'))
    <span class="error">
        {{ $errors->first('password') }}
    </span>
    @endif

    <input class="editor" type="password" name="password_confirmation" placeholder="Confirm your new password">
    @if ($errors->has('password_confirmation'))
        <span class="error">
            {{ $errors->first('password_confirmation') }}
        </span>
    @endif

    <input class="editor" type="text" name="user_address" value="{{$admin->user_address}}">
    @if ($errors->has('user_address'))
    <span class="error">
        {{ $errors->first('user_address') }}
    </span>
    @endif

    <input class="editor" type="tel" name="phone" value="{{$admin->phone}}">
    @if ($errors->has('phone'))
    <span class="error">
        {{ $errors->first('phone') }}
    </span>
    @endif

    <button type="submit" id="edit_button" class="edit_button">Confirm</button>
</form>
<form method="POST" action="/admins/{{$admin->id}}/delete">
    @csrf
    @method('DELETE')
    <button id="delete_button" class="edit_button" type="submit" 
    onclick="return confirm('Are you sure you want to delete this account?');">Delete account</button>
</form>
@endsection