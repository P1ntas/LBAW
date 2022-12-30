@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')

<form method="POST" action="{{ route('password.update') }}">
    @csrf

    <input type="hidden" name="token" value="{{ $token }}">

    <input type="email" name="email" placeholder="email" required>
    @if ($errors->has('email'))
        <span class="error">
            {{ $errors->first('email') }}
        </span>
    @endif

    <input class="words" type="password" name="password" placeholder="password" required>
    @if ($errors->has('password'))
        <span class="error">
            {{ $errors->first('password') }}
        </span>
    @endif

    <input class="words" type="password" name="password_confirmation" placeholder="repeat password" required>
    @if ($errors->has('password_confirmation'))
        <span class="error">
            {{ $errors->first('password_confirmation') }}
        </span>
    @endif
</form>

@endsection