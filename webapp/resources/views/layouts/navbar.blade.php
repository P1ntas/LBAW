<header id="navbar">
  <a href="{{ url('/') }}">Off The Shelf</a>
  <hr>
  <a href="{{ url('books') }}">Books</a>
  @auth 
    <a href="{{ url('logout') }}">Logout</a>
    <a href="/users/{{Auth::user()->id}}">{{ Auth::user()->name }}</a>
  @endauth
  @guest 
    <a href="{{ url('login') }}">Login</a>
    <a href="{{ url('register') }}">Register</a>
  @endguest
</header>