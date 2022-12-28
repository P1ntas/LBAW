<form id="loginForm" class="inputs" method="POST" action="/login">
    {{ csrf_field() }}

    <input id="email" class="words" type="email" name="email" placeholder="email" required>
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