@extends('layouts.app')

@section('title', $book->title)

@section('content')

<article class="book" data-id="{{ $book->id }}">
    <a href="/books/{{ $book->id }}">{{ $book->title }}</a>
    <p>ISBN: {{ $book->isbn }}</p>
    <p>Year: {{ $book->year }}</p>
    <p>Price: {{ $book->price }} €</p>
    <p>Stock: {{ $book->stock }} units</p>
    <p>Edition: {{ $book->book_edition }}</p>
    <p>Description: {{ $book->book_description }}</p>
    <p>Category: {{ $book->category->name }}</p>
    <p>Publisher: {{ $book->publisher->name }}</p>
    <p>Author(s):</p>
    @foreach ($authors as $author)
        <p>{{ $author->name }}</p>
    @endforeach
    @auth 
        <form method="POST" action="/api/books/{{$book->id}}/cart">
            <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
            <input type="submit" value="Add to cart">
        </form>
        <form method="POST" action="/api/books/{{$book->id}}/wish">
            <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
            <input type="submit" value="Add to wishlist">
        </form>
    @endauth
    @if (Auth::user()->isAdmin())
        <a href="/books/{{ $book->id }}/edit">Edit Book</a>
    @endif
    <p>Reviews:</p>
    @auth 
        <form method="POST" action="/api/books/{{$book->id}}/review">
            <label for="rating">Rating</label>
            <input id="rating" type="number" name="rating" min="0" max="5">
            <label for="comment">Comment</label>
            <input id="comment" type="text" name="comment">
            @if ($errors->has('comment'))
            <span class="error">
                {{ $errors->first('comment') }}
            </span>
            @endif
            <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
            <input type="submit" value="Submit review">
        </form>
    @endauth
    @foreach ($book->reviews as $review)
        @if (Auth::user()->id == $review->user_id)
            <form method="POST" action="/api/books/{{$book->id}}/review/remove">
                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                <input type="submit" value="Remove review">
            </form>
        @endif
        <p>From: {{ $review->user->name }}</p>
        <p>Date: {{ $review->review_date }}</p>
        <p>Rating: {{ $review->rating }}</p>
        <p>Comment: {{ $review->comment }}</p>
    @endforeach
</article>

@endsection
