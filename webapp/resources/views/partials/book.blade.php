<div class="card">
    <a href="/books/{{ $book->id }}">
        @php ($picture = $book->photo) @endphp
        @if (empty($picture))
            <img src="{{ URL::asset('images/book.jpg') }}" alt="bookPhoto">
        @else
            <img src="{{ URL::asset('images/books/' . $picture->photo_image) }}" alt="bookPhoto">
        @endif
    </a>
    <a href="/books/{{ $book->id }}"><p>{{ $book->title }}</p></a>
    <p class="price">Price: <span>{{ $book->price }} €</span><p>
</div>