@extends('layouts.app')

@section('title', '404')

@section('content')

<html lang="en-US">
    <head>
        <title>Off The Shelf</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/style.css">
        <script src="https://code.iconify.design/iconify-icon/1.0.1/iconify-icon.min.js"></script>
        <script src="../javascript/header.js" defer></script>
        <script src="../javascript/book.js" defer></script>

    </head>
    <body>
        <header>
            <div id="headerWrapper">
                <div id ="imgTitle">
                    <img src="../pictures/logo.png" alt="logo">
                    <h1 a href="#" id="name">Off The Shelf</h1>
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
                <div id="hSearch">
                    <button id="magnifierSearch">
                        <iconify-icon icon="simple-line-icons:magnifier"></iconify-icon>
                    </button>
                    <input id="hSearchText" type="text" placeholder="search">
                </div>
                <div id="hLog">
                    <button id="headerLogin" type="submit">Login</button>
                </div>
                <nav id="hamburguer">
                    <ul id="hambMenu">
                        <li class="item"><a href="#" class="hLink">Home</a></li>
                        <li class="item"><a href="#" class="hLink">Books</a></li>
                        <li class="item"><a href="#" class="hLink">Collections</a></li>
                        <li class="item"><a href="#"class="hLink">Categories</a></li>
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
        <main>
            <!-- Redirect starts here -->
            <div class="redWrapper">
                <div class="redWrapper2">
                    <img src="../pictures/cat.JPG" alt="redirectPhoto" id="catP">
                    <p>You didn't find what you were looking for, but you found Morena.</p>
                    <p>She needs a new home. If you'd like to adopt her, please contact the owners of this site.</p>
                </div>
            </div>
            <!--Redirect ends here -->
        </main>
        <footer>
            <ul id="fItems">
                <li class="fLink"><a href="#">Contact Us</a></li>
                <li class="fLink"><a href="#">About Us</a></li>
                <li class="fLink"><a href="#">FAQ</a></li>
            </ul>
            <p id="cp">Copyright &copy; Copyright License</p>
          </footer>
    </body>
</html>





@endsection