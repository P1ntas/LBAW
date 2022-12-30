<form method="POST" action="/books/{{ $book->id }}/review">
    @csrf

    <input type="number" name="rating" min="0" max="5" step="1" placeholder="rate this book">
    @if ($errors->has('rating'))
        <span class="error">
            {{ $errors->first('rating') }}
        </span>
    @endif

    <input type="text" name="comment" placeholder="add your comment">
    @if ($errors->has('comment'))
        <span class="error">
            {{ $errors->first('comment') }}
        </span>
    @endif
    <button type="submit" id="addReview" class="edit_button">Submit Review</button>
</form>