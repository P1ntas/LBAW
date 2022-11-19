<article class="book" data-id="{{ $book->id }}">
    <a href="/books/{{ $book->id }}">{{ $book->title }}</a>
    <p>Price: {{ $book->price }}</p>
    <p>Category: {{ $book->category->name }}
    <p>Author(s):</p>
    @foreach ($book->authors as $author)
        <p>{{ $author->name }}</p>
    @endforeach
</article>
