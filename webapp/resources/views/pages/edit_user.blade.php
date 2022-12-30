@extends('layouts.app')

@section('title', $user->name)

@section('content')

<h1>Edit Profile</h1>
<div id="editWrapper">
    <!-- user_photo -->
</div>
<form id="fedit" method="POST" action="/users/{{$user->id}}/edit">
    @csrf
    @method('PUT')

    <input class="editor" type="text" name="name" value="{{$user->name}}">
    @if ($errors->has('name'))
    <span class="error">
        {{ $errors->first('name') }}
    </span>
    @endif

    <input class="editor" type="email" name="email" value="{{$user->email}}">
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

    <input class="editor" type="text" name="user_address" value="{{$user->user_address}}">
    @if ($errors->has('user_address'))
    <span class="error">
        {{ $errors->first('user_address') }}
    </span>
    @endif

    <input class="editor" type="tel" name="phone" value="{{$user->phone}}">
    @if ($errors->has('phone'))
    <span class="error">
        {{ $errors->first('phone') }}
    </span>
    @endif

    <button type="submit" id="edit_button" class="edit_button">Confirm</button>
</form>
<form method="POST" action="/users/{{$user->id}}/delete">
    @csrf
    @method('DELETE')
    <button id="delete_button" class="edit_button" type="submit" 
    onclick="return confirm('Are you sure you want to delete this account?');">Delete account</button>
</form>

@endsection