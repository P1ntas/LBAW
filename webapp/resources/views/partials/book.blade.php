<article class="book" data-id="{{ $book->id }}">
    <a href="/books/{{ $book->id }}">{{ $book->title }}</a>
    <p>Price: {{ $book->price }}</p>
    <p>Category: {{ $book->id_category }}</p>
</article>
