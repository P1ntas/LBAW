<div class="Checkout">
    <div>
        <p class="pclass">Price: <span>{{ $book->price }} €</span></p>
        <form method="POST" action="/users/{{ Auth::user()->id }}/cart/{{ $book->id }}">
            @csrf
            @method('DELETE')
            <button type="submit">
                <iconify-icon icon="ion:trash-outline" class="trash"></iconify-icon>
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