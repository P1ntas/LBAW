<header id="navbar">
  <a href="{{ url('/') }}">Off The Shelf</a>
  <hr>
  @auth
    @if (Auth::user()->isAdmin())
    <a href="{{ url('logout') }}">Logout</a>
    <a href="/admins/{{Auth::user()->id}}">{{ Auth::user()->name }}</a>
    @else
    <a href="/users/{{Auth::user()->id}}/cart">Shopping Cart</a>
    <a href="{{ url('logout') }}">Logout</a>
    <a href="/users/{{Auth::user()->id}}">{{ Auth::user()->name }}</a>
    @endif
  @endauth
  @guest 
    <a href="{{ url('login') }}">Login</a>
    <a href="{{ url('register') }}">Register</a>
  @endguest
</header>