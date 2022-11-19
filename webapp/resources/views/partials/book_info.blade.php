<article class="book" data-id="{{ $book->id }}">
    <a href="/books/{{ $book->id }}">{{ $book->title }}</a>
    <p>ISBN: {{ $book->isbn }}</p>
    <p>Year: {{ $book->year }}</p>
    <p>Price: {{ $book->price }}</p>
    <p>Stock: {{ $book->stock }}</p>
    <p>Edition: {{ $book->book_edition }}</p>
    <p>Description: {{ $book->book_description }}</p>
    <p>Category: {{ $category->name }}</p>
    <p>Publisher: {{ $publisher->name }}</p>
    <p>Author(s):</p>
    @foreach ($authors as $author)
        <p>{{ $author->name }}</p>
    @endforeach
    @auth 
        <form method="POST" action="/api/books/{{$book->id}}">
            <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
            <input type="submit" value="Add to cart">
        </form>
    @endauth
    <p>Reviews:</p>
    @foreach ($reviews as $review)
        <p>From: {{ $review->user->name }}</p>
        <p>Date: {{ $review->review_date }}</p>
        <p>Rating: {{ $review->rating }}</p>
        <p>Comment: {{ $review->comment }}</p>
    @endforeach
</article>
