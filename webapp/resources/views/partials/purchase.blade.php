<div id="purchase">
    @php ($final_cost = 1.50)
    @foreach ($purchase->books as $book)
        @php ($final_cost += $book->price)
        <a href="/books/{{ $book->id }}#bookReview">
            <p class="pclass">{{ $book->title }} <span>review</span></p>
        </a>
    @endforeach
    <p class="pclass">Arrival date: <span>{{ $purchase->delivery->arrival }}</span></p>
    <div id="purWrapper">
        <p class="pclass">Status: <span>{{ $purchase->state_purchase }}</span></p>
        @if (Auth::user()->isAdmin())
            <form method="POST" action="/users/{{ $purchase->user_id }}/purchases/{{ $purchase->id }}/status">
                @csrf
                @method('PUT')
                <label for="status">Order status</label><br>
                <select id="status" name="status">
                  <option value="Received">Received</option>
                  <option value="Dispatched">Dispatched</option>
                  <option value="Delivered">Delivered</option>
                </select>
                <button type="submit">
                    <iconify-icon icon="mdi:pencil" id="space"></iconify-icon>
                </button>
            </form>
        @endif
    </div>
    <div id="purWrapper">
        <p class="pclass">Final cost: <span>{{ $final_cost }} €</span></p>
        @php ($final_state = 'Delivered')
        @if (!Auth::user()->isAdmin() && $purchase->state_purchase != $final_state)
            <form method="POST" action="/users/{{ $purchase->user_id }}/purchases/{{ $purchase->id }}/cancel">
                @csrf
                @method('DELETE')
                <button type="submit" 
                onclick="return confirm('Are you sure you want to cancel this order?');">
                    <iconify-icon icon="ion:trash-outline" class="trash trash2"></iconify-icon>
                </button>
            </form>
        @endif
    </div>
</div>