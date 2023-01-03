<header>
  <div id="headerWrapper">
    <div id ="imgTitle">
      <img src="{{ URL::asset('images/logo.png') }}" alt="logo">
      <h1><a href="/" id="name">Off The Shelf</a></h1>
    </div>
    <div id="headerWrapper2">
      @if (Auth::check() && !Auth::user()->isAdmin())
        <div id="headerButtons">
          @php ($notifications = Auth::user()->notifications)
          <button class="butBell" onclick="showNotifs()">
            <iconify-icon class="bigger" icon="mdi:bell-circle" style="color: #141228;"></iconify-icon>
            ({{ count($notifications) }})
          </button>
          <div id="notifs" style="display:none;">
            @foreach ($notifications as $notification)
              <div class="flexor1">
              <p>{{ $notification->content }}</p>
              <form class="notif" onsubmit="deleteNotif({{ $notification->id }}); return false;">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <button type="submit">X</button>
              </form>
              </div>
            @endforeach
          </div>
          <a id="addWish" href="/users/{{ Auth::user()->id }}/wishlist">
            <iconify-icon icon="mdi:cards-heart-outline"></iconify-icon>
          </a>
          <button id="hCart" type="submit">
            <a href="/users/{{ Auth::user()->id }}/cart" >
              <iconify-icon icon="material-symbols:shopping-cart-outline-rounded" id="cart"></iconify-icon>
            </a>
          </button>
        </div>
      @endif
      <form class="searching" method="POST" action="/books/search">
        @csrf
        <div id="hSearch">
          <button id="magnifierSearch">
            <iconify-icon icon="simple-line-icons:magnifier"></iconify-icon>
          </button>
          <input id="hSearchText" type="text" name="search" value="{{ old('search') }}" placeholder="Type a book/author">
        </div>
      </form>
      <div id="hLog">
        @auth
          @if (Auth::user()->isAdmin())
            <a id="headerLogin" href="/admins/{{ Auth::user()->id }}">{{ Auth::user()->name }}</a>
            <div id="userPopup">
              <ul id ="userActions">
                <li><a href="/users">Users</a></li>
                <li><a href="/admins/{{ Auth::user()->id }}/edit">Edit Profile</a></li>
                <li><a href="/logout">Sign Out</a></li>
              </ul>
            </div>
          @else
            <a id="headerLogin" href="/users/{{ Auth::user()->id }}">{{ Auth::user()->name }}</a>
            <div id="userPopup">
              <ul id ="userActions">
                <li><a href="/users/{{ Auth::user()->id }}/purchases">Purchases</a></li>
                <li><a href="/users/{{ Auth::user()->id }}/edit">Edit Profile</a></li>
                <li><a href="/logout">Sign Out</a></li>
              </ul>
            </div>
          @endif
        @else
          <a id="headerLogin" href="/login">Sign In</a>
        @endauth
      </div>
      <nav id="hamburguer">
        <ul id="hambMenu">
          <li class="item"><a href="/" class="hLink">Home</a></li>
          <li class="item"><a href="/books" class="hLink">Books</a></li>
          <li class="item"><a href="/collections" class="hLink">Collections</a></li>
          <li class="item"><a href="/categories"class="hLink">Categories</a></li>
        </ul>
        <div id="hamb">
          <span class="bar"></span>
          <span class="bar"></span>
          <span class="bar"></span>
        </div>
      </nav>
    </div>
  </div>
</header>
