@extends('layouts.app')

@section('notification')
@if (Session::has('notification'))
    <div class="notification {{ Session::get('notification_type') }}">
      {{ Session::get('notification') }}
    </div>
    <button class="close-button" type="button">X</button>
@endif
@endsection

@section('content')
<div id="bookInfo">
    <img src="{{ URL::asset('images/book.jpg') }}" alt="bookPhoto" id="bookP">
    @auth 
        @if (Auth::user()->isAdmin())
            <form method="GET" action="/books/{{ $book->id }}/edit">
                <button id="editButton">
                    <figcaption>Edit Book <iconify-icon icon="mdi:pencil"></iconify-icon></figcaption>
                </button>
            </form>
        @else 
            <div class="tired">
                <form method="GET" action="/books/{{ $book->id }}/wish">
                    <button id="addWish" class="bookButtons" type="submit">
                        <iconify-icon icon="mdi:cards-heart-outline"></iconify-icon>
                    </button>
                </form>
                <form method="GET" action="/books/{{ $book->id }}/cart">
                    <button id="buy" class="bookButtons" type="submit">Add to cart</button>
                </form>
            </div>
        @endif
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
            @if (Auth::check() && !Auth::user()->isAdmin())
                @include('partials.add_review')
            @endif
            @foreach ($book->reviews as $review)
                @auth
                    @if (Auth::user()->id == $review->user_id)
                        <div id="revWrapper2">
                            <div id="revWrapper">
                                <div id="try2">
                                    <form method="POST" action="/books/{{ $book->id }}/review/{{ $review->id }}/remove">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">
                                            <iconify-icon icon="ion:trash-outline" class="trash"></iconify-icon>
                                        </button>
                                    </form>
                                </div>
                                <div id="revHeader">
                                    <p class="username">{{ $review->user->name }}</p>
                                    <img src="{{ URL::asset('images/avatar.jpg') }}" alt="userPhoto" class="bookU">
                                </div>
                            </div>
                            <form method="POST" action="/books/{{ $book->id }}/review/{{ $review->id }}/edit">
                                @csrf
                                @method('PUT')

                                <input type="number" name="rating" min="0" max="5" step="1" value="{{ $review->rating }}">
                                @if ($errors->has('rating'))
                                    <span class="error">
                                        {{ $errors->first('rating') }}
                                    </span>
                                @endif

                                <input type="text" name="comment" value="{{ $review->comment }}">
                                @if ($errors->has('comment'))
                                    <span class="error">
                                        {{ $errors->first('comment') }}
                                    </span>
                                @endif

                                <button type="submit" id="addReview" class="edit_button">
                                    <iconify-icon icon="mdi:pencil" id="editUser"></iconify-icon>
                                </button>
                            </form>
                        </div>
                    @elseif (Auth::user()->isAdmin())
                        <div id="revWrapper2">
                            <div id="revWrapper">
                                <div id="try2">
                                    <form method="POST" action="/books/{{ $book->id }}/review/{{ $review->id }}/remove">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">
                                            <iconify-icon icon="ion:trash-outline" class="trash"></iconify-icon>
                                        </button>
                                    </form>
                                </div>
                                <div id="rating">
                                    <p>{{ $review->rating }}</p>
                                    <iconify-icon icon="material-symbols:star" id="star" style="color: #ffc700;"></iconify-icon>
                                </div>  
                                <div id="revHeader">
                                    <p class="username">{{ $review->user->name }}</p>
                                    <img src="{{ URL::asset('images/avatar.jpg') }}" alt="userPhoto" class="bookU">
                                </div>
                            </div>
                            <p>{{ $review->comment }}</p>
                        </div>
                    @endif
                @else
                    <div id="revWrapper2">
                        <div id="revWrapper">
                            <div id="rating">
                                <p>{{ $review->rating }}</p>
                                <iconify-icon icon="material-symbols:star" id="star" style="color: #ffc700;"></iconify-icon>
                            </div>
                            <div id="revHeader">
                                <p class="username">{{ $review->user->name }}</p>
                                <img src="{{ URL::asset('images/avatar.jpg') }}" alt="userPhoto" class="bookU">
                            </div>
                        </div>
                        <p>{{ $review->comment }}</p>
                    </div>
                @endauth
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