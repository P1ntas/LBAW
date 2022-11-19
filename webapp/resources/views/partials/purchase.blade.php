<article class="purchase" data-id="{{ $purchase->id }}">
    <p>Date: {{ $purchase->purchase_date }}</p>
    <p>Book(s):</p>
    @foreach ($purchase->books as $book)
        <p>{{ $book->title }}</p>
    @endforeach
    <p>State: {{ $purchase->state_purchase }}</p>
</article>