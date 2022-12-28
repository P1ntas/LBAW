@extends('layouts.app')

@section('content')

<div id="login">
    <div class="formul">
        <div class="button_rectangle">
            <div id="log"></div>
            <button type="button" id="log1" class="button_log" onclick="login()">Login</button>
            <button type="button" id="log2" class="button_log" onclick="register()">Register</button>
        </div>
        <form id="loginForm" class="inputs" method="POST" action="/login">
            {{ csrf_field() }}

            <input id="email" class="words" type="email" name="email" value="{{ old('email') }}" placeholder="email/username" required>
            @if ($errors->has('email'))
                <span class="error">
                    {{ $errors->first('email') }}
                </span>
            @endif

            <input id="password" class="words" type="password" name="password" placeholder="password" required>
            @if ($errors->has('password'))
                <span class="error">
                    {{ $errors->first('password') }}
                </span>
            @endif
            
            <label>
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> remember me
            </label>

            <button type="submit" class="sub">Login</button>
        </form>
        @include('auth.register')
    </div>
</div>

@endsection