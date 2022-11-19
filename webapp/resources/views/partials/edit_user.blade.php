<article class="user" data-id="{{ $user->id }}">
    <form method="POST" action="/api/users/{{Auth::user()->id}}/edit">
        {{ csrf_field() }}

        <label for="name">Name</label>
        <input id="name" type="text" name="name" value="{{Auth::user()->name}}">
        @if ($errors->has('name'))
        <span class="error">
            {{ $errors->first('name') }}
        </span>
        @endif

        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{Auth::user()->email}}">
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
        <input id="user_address" type="text" name="user_address" value="{{Auth::user()->user_address}}">
        @if ($errors->has('user_address'))
        <span class="error">
            {{ $errors->first('user_address') }}
        </span>
        @endif

        <label for="phone">Phone Number</label>
        <input id="phone" type="tel" name="phone" value="{{Auth::user()->phone}}">
        @if ($errors->has('phone'))
        <span class="error">
            {{ $errors->first('phone') }}
        </span>
        @endif

        <input type="hidden" name="blocked" value="FALSE">

        <button type="submit">Confirm</button>
        <a class="button button-outline" href="/users/{{Auth::user()->id}}">Cancel</a>
    </form>
</article>