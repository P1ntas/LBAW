<div class="Checkout">
    <div>
        <p class="pclass">{{ $book->title }}</p>
        <form method="POST" action="/users/{{ Auth::user()->id }}/wishlist/{{ $book->id }}">
            @csrf
            @method('DELETE')
            <button type="submit">
                <!-- x_photo -->
                <p>X</p>
            </button>
        </form>
    </div>
    <a href="/books/{{ $book->id }}">
        <!-- book_photo -->
    </a>
</div>