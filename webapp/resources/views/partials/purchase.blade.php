<div id="purchase">
    @php ($finalcost = 1.50)
    @foreach ($purchase->books as $book)
        @php ($finalcost += $book->price)
        <a href="/books/{{ $book->id }}">
            <p class="pclass">Item: <span>{{ $book->title }}</span></p>
        </a>
    @endforeach
    <p class="pclass">Arrival date: <span>{{ $purchase->delivery->arrival }}</span></p>
    <div id="purWrapper">
        <p class="pclass">Status: <span>{{ $purchase->state_purchase }}</span></p>
    </div>
    <div id="purWrapper">
        <p class="pclass">Final cost: <span>{{ $finalcost }} €</span></p>
    </div>
</div>