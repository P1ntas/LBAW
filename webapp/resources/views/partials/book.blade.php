<article>
    <p>Title: {{ $book->title }}</p>
    <p>Price: {{ $book->price }} €</p>
    <p>Category: {{ $book->category->name }}
    <p>Author(s):</p>
    @foreach ($book->authors as $author)
        <p>{{ $author->name }}</p>
    @endforeach
</article>
