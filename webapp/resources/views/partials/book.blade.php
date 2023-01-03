<div class="card">
    <a href="/books/{{ $book->id }}"><img src="{{ URL::asset('images/book.jpg') }}" alt="logo"></a>
    <a href="/books/{{ $book->id }}"><p>{{ $book->title }}</p></a>
    <p class="price">Price: <span>{{ $book->price }} €</span><p>
</div>