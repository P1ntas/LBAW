<header id="navbar">
  <h1><a href="/">Off The Shelf</a></h1>
  <hr>
  @auth
    @if (Auth::user()->isAdmin())
    <a href="/logout">Logout</a>
    <a href="/admins/{{Auth::user()->id}}">{{ Auth::user()->name }}</a>
    @else
    <a href="/users/{{Auth::user()->id}}/cart">Shopping Cart</a>
    <a href="/logout">Logout</a>
    <a href="/users/{{Auth::user()->id}}">{{ Auth::user()->name }}</a>
    @endif
  @endauth
  @guest 
    <a href="/login">Login</a>
    <a href="/register">Register</a>
  @endguest
</header>