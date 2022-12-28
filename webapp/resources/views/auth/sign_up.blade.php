<form id="register" class="inputs" method="POST" action="/register">
  {{ csrf_field() }}
  
  <input class="words" type="email" name="email" placeholder="email" required>
  @if ($errors->has('email'))
    <span class="error">
      {{ $errors->first('email') }}
    </span>
  @endif

  <input class="words" type="text" name="name" placeholder="username" required>
  @if ($errors->has('name'))
    <span class="error">
      {{ $errors->first('name') }}
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
  
  <input class="words" type="text" name="user_address" placeholder="address" required>
  @if ($errors->has('user_address'))
    <span class="error">
      {{ $errors->first('user_address') }}
    </span>
  @endif

  <input class="words" type="tel" name="phone" placeholder="phone number">
  @if ($errors->has('phone'))
    <span class="error">
      {{ $errors->first('phone') }}
    </span>
  @endif

  <input type="hidden" name="blocked" value="FALSE">
  <input type="hidden" name="admin_perms" value="FALSE">

  <button type="submit" class="sub">Register</button> 
</form>
