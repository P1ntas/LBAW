@extends('layouts.app')

@section('title', $user->name)

@section('content')

<article class="user" data-id="{{ $user->id }}">
    <form method="POST" action="/api/users/{{$user->id}}/edit">
        {{ csrf_field() }}

        <label for="name">Name</label>
        <input id="name" type="text" name="name" value="{{$user->name}}">
        @if ($errors->has('name'))
        <span class="error">
            {{ $errors->first('name') }}
        </span>
        @endif

        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{$user->email}}">
        @if ($errors->has('email'))
        <span class="error">
            {{ $errors->first('email') }}
        </span>
        @endif

        <label for="password">New Password</label>
        <input id="password" type="password" name="password" placeholder="Insert your new password">
        @if ($errors->has('password'))
        <span class="error">
            {{ $errors->first('password') }}
        </span>
        @endif

        <label for="password-confirm">Confirm Password</label>
        <input id="password-confirm" type="password" name="password_confirmation" placeholder="Confirm your new password">

        <label for="user_address">Address</label>
        <input id="user_address" type="text" name="user_address" value="{{$user->user_address}}">
        @if ($errors->has('user_address'))
        <span class="error">
            {{ $errors->first('user_address') }}
        </span>
        @endif

        <label for="phone">Phone Number</label>
        <input id="phone" type="tel" name="phone" value="{{$user->phone}}">
        @if ($errors->has('phone'))
        <span class="error">
            {{ $errors->first('phone') }}
        </span>
        @endif

        @if (Auth::user()->isAdmin())
            <label for="blocked">Blocked</label>
            @if ($user->isBlocked())
                <input type="radio" name="blocked" value="TRUE" checked="checked">Yes
                <input type="radio" name="blocked" value="FALSE">No
            @else
                <input type="radio" name="blocked" value="TRUE">Yes
                <input type="radio" name="blocked" value="FALSE" checked="checked">No
            @endif
        @else
            <input type="hidden" name="blocked" value="{{$user->blocked}}">
        @endif

        <button type="submit">Confirm</button>
        <a class="button button-outline" href="/users/{{$user->id}}">Cancel</a>
    </form>
</article>

@endsection
