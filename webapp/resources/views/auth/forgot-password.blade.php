@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')

<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <input type="email" name="email" placeholder="email" required>
    @if ($errors->has('email'))
        <span class="error">
            {{ $errors->first('email') }}
        </span>
    @endif

    <button type="submit">Send Password Reset Link</button>
</form>

@endsection