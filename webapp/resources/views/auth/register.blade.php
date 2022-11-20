@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('register') }}">
    {{ csrf_field() }}

    <label for="name">Name *</label>
    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
    @if ($errors->has('name'))
      <span class="error">
          {{ $errors->first('name') }}
      </span>
    @endif

    <label for="email">Email *</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required>
    @if ($errors->has('email'))
      <span class="error">
          {{ $errors->first('email') }}
      </span>
    @endif

    <label for="password">Password *</label>
    <input id="password" type="password" name="password" required>
    @if ($errors->has('password'))
      <span class="error">
          {{ $errors->first('password') }}
      </span>
    @endif

    <label for="password-confirm">Confirm Password *</label>
    <input id="password-confirm" type="password" name="password_confirmation" required>

    <label for="user_address">Address</label>
    <input id="user_address" type="text" name="user_address" value="{{ old('user_address') }}">
    @if ($errors->has('user_address'))
    <span class="error">
        {{ $errors->first('user_address') }}
    </span>
    @endif

    <label for="phone">Phone Number</label>
    <input id="phone" type="tel" name="phone" value="{{ old('phone') }}">
    @if ($errors->has('phone'))
    <span class="error">
        {{ $errors->first('phone') }}
    </span>
    @endif

    <input type="hidden" name="blocked" value="FALSE">
    <input type="hidden" name="admin_perms" value="FALSE">

    <p>Fields marked with * must be filled.</p>

    <button type="submit">Register</button>
    <a class="button button-outline" href="{{ route('login') }}">Login</a>
</form>
@endsection
