<header>
  <div id="headerWrapper">
    <div id ="imgTitle">
      <!-- logo.png -->
      <h1><a href="/" id="name">Off The Shelf</a></h1>
    </div>
    <div id="headerWrapper2">
      <div id="headerButtons">
        <button id="addWish" type="submit">
          <iconify-icon icon="mdi:cards-heart-outline"></iconify-icon>
        </button>
        <button id="hCart" type="submit">
          <iconify-icon icon="material-symbols:shopping-cart-outline-rounded" id="cart"></iconify-icon>
        </button>
      </div>
      <form method="POST" action="/books/search">
        {{ csrf_field() }}
        <div id="hSearch">
          <button id="magnifierSearch">
            <iconify-icon icon="simple-line-icons:magnifier"></iconify-icon>
          </button>
          <input id="hSearchText" type="text" name="search" placeholder="Type a book/author">
        </div>
      </form>
      <div id="hLog">
        @auth
          <a id="headerLogin" href="/users/{{ Auth::user()->id }}">{{ Auth::user()->name }}</a>
          <div id="userPopup">
            <ul id ="userActions">
              <li><a href="/">Purchases</a></li>
              <li><a href="/users/{{ Auth::user()->id }}/edit">Edit Profile</a></li>
              <li><a href="/logout">Sign out</a></li>
            </ul>
          </div>
        @else
          <a href="/login">Sign in</a>
          <a href="/register">Sign up</a></li>
        @endauth
      </div>
      <nav id="hamburguer">
        <ul id="hambMenu">
          <li class="item"><a href="/" class="hLink">Home</a></li>
          <li class="item"><a href="/books" class="hLink">Books</a></li>
          <li class="item"><a href="/" class="hLink">Collections</a></li>
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
