<article class="purchase" data-id="{{ $purchase->id }}">
    <p>Checkout date: {{ $purchase->purchase_date }}</p>
    <p>Book(s):</p>
    @php ($finalcost = 1.50)
    @foreach ($purchase->books as $book)
        @php ($finalcost += $book->price)
        <p>{{ $book->title }}</p>
    @endforeach
    <p>Final cost: {{$finalcost}} €</p>
    <p>State: {{ $purchase->state_purchase }}</p>
    <p>Arrival date:  {{ $purchase->delivery->arrival }}</p>
    <p>Delivery address:  {{ $purchase->delivery->delivery_address }}</p>
</article>