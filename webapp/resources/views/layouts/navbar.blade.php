<header id="navbar">
  <a href="{{ url('/') }}">Off The Shelf</a>
  <hr>
  @auth 
    <a href="/users/{{Auth::user()->id}}">{{ Auth::user()->name }}</a>
    <a href="{{ url('logout') }}">Logout</a>
  @endauth 
  @guest 
    <a href="{{ url('login') }}">Login</a>
    <a href="{{ url('register') }}">Register</a>
  @endguest
</header>