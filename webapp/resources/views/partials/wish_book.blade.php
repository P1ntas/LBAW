<div class="Checkout">
    <div>
        <p class="pclass">{{ $book->title }}</p>
        <form method="POST" action="/users/{{ Auth::user()->id }}/wishlist/{{ $book->id }}">
            @csrf
            @method('DELETE')
            <button type="submit">
                <img src="{{ URL::asset('images/x.png') }}" alt="xCheckout" id="imgCheckout">
            </button>
        </form>
    </div>
    <a href="/books/{{ $book->id }}">
        @php ($picture = $book->photo) @endphp
        @if (empty($picture))
            <img src="{{ URL::asset('images/book.jpg') }}" alt="bookPhoto" id="imgPurchase">
        @else
            <img src="{{ URL::asset('images/books/' . $picture->photo_image) }}" alt="bookPhoto" id="imgPurchase">
        @endif
    </a>
</div>