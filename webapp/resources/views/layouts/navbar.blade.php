<nav>
  <div>
    <button type="button">
      <span></span>
    </button>
    <a href="{{ URL::to('/') }}">Off The Shelf</a>
    <div>
      <ul>
        @auth
          <li>
            <a href="#">
              <i></i> {{ Auth::user()->name }}
            </a>
            <div>
              <a href="{{ URL::to('/') }}">Books</a>
              <a href="{{ URL::to('/') }}">My Profile</a>
              <a href="{{ URL::to('/') }}"
                 onclick="event.preventDefault();
                 document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
              </a>
              <form id="logout-form" action="{{ URL::to('/') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
              </form>
            </div>
          </li>
        @endauth
        @guest
          <li>
            <a href="#">Auth</a>
            <div>
              <a href="{{ URL::to('/') }}">Login</a>
              <a href="{{ URL::to('/') }}">Register</a>
            </div>
          </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>
