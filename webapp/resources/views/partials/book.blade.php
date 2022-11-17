<article class="book" data-id="{{ $book->id }}">
    <p>Title: {{ $book->title }}</p>
    <p>ISBN: {{ $book->isbn }}</p>
    <p>Year: {{ $book->year }}</p>
    <p>Price: {{ $book->price }}</p>
    <p>Title: {{ $book->title }}</p>
    <p>Stock: {{ $book->stock }}</p>
    <p>Edition: {{ $book->book_edition }}</p>
    <p>Description: {{ $book->book_description }}</p>
    <p>Category: {{ $book->id_category }}</p>
    <p>Publisher: {{ $book->id_publisher }}</p>
</article>
