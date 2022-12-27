<article class="book" data-id="{{ $book->id }}">
    <a href="/books/{{ $book->id }}">{{ $book->title }}</a>
    <p>Price: {{ $book->price }} €</p>
    <p>Category: {{ $book->category->name }}
    <p>Author(s):</p>
    @foreach ($book->authors as $author)
        <p>{{ $author->name }}</p>
    @endforeach
    @if($book->stock > 0)
        <p>Product Available</p>
    @else
        <p>Product Unavailable</p>
    @endif
    <form method="POST" action="/api/users/{{Auth::user()->id}}/wishlist">
        <input type="hidden" name="book_id" value="{{$book->id}}">
        <input type="submit" value="Remove from wishlist">
    </form>
</article>