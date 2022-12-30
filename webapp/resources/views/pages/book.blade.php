@extends('layouts.app')

@section('title', '$book->title')

@section('content')

<div id="bookInfo">
    <!-- book_photo -->
    @auth
        <form method="GET" action="/books/{{ $book->id }}/cart">
            <button id="buy" class="bookButtons" type="submit">Add to cart</button>
        </form>
    @endauth
    <div id="bookDetails">
        <span id="description" class="bookLable activeLabel">Description</span>
        <span id="reviewBook" class="bookLable">Reviews</span>
        <span id="details" class="bookLable">Details</span>
        <span id="autor" class="bookLable">Author(s)</span>
    </div>
    <div id="bookDetailed">
        <article id="bookDescription" class="bookContents">{{ $book->book_description }}</article>
        <div id="bookReview" class="bookContents hideBook">
            @foreach ($book->reviews as $review)
                <div id="revWrapper2">
                    <div id="revWrapper">
                        <div id="rating">
                            <p>{{ $review->rating }}</p>
                            <iconify-icon icon="material-symbols:star" id="star" style="color: #ffc700;"></iconify-icon>
                        </div>
                        <div id="revHeader">
                            <a href="/" class="username">{{ $review->user->name }}</a>
                            <!-- user_photo -->
                        </div>
                    </div>
                    <p>{{ $review->comment }}</p>
                </div>
            @endforeach
        </div>
        <table id="detailsBook" class="bookContents hideBook">
            <tr>
                <td class="detailsHeader">Title:</td>
                <td class="detailsText">{{ $book->title }}</td>
            </tr>
            <tr>
                <td class="detailsHeader">ISBN:</td>
                <td class="detailsText">{{ $book->isbn }}</td>
            </tr>
            <tr>
                <td class="detailsHeader">Year:</td>
                <td class="detailsText">{{ $book->year }}</td>
            </tr>
            <tr>
                <td class="detailsHeader">Price:</td>
                <td class="detailsText">{{ $book->price }} €</td>
            </tr>
            <tr>
                <td class="detailsHeader">Stock:</td>
                <td class="detailsText">{{ $book->stock }} units</td>
            </tr>
            <tr>
                <td class="detailsHeader">Edition:</td>
                <td class="detailsText">{{ $book->book_edition }}</td>
            </tr>
            <tr>
                <td class="detailsHeader">Category:</td>
                <td class="detailsText">{{ $book->category->name }}</td>
            </tr>
            <tr>
                <td class="detailsHeader">Publisher:</td>
                <td class="detailsText">{{ $book->publisher->name }}</td>
            </tr>
        </table>
        <div id="bookAutor" class="bookContents hideBook">
            @foreach ($book->authors as $author)
                <p>{{ $author->name }}</p>
            @endforeach
        </div>
    </div>
</div>

@endsection