<article class="purchase" data-id="{{ $purchase->id }}">
    <hr>
    <p>Checkout date: {{ $purchase->purchase_date }}</p>
    <p>Book(s):</p>
    @php ($finalcost = 1.50)
    @foreach ($purchase->books as $book)
        @php ($finalcost += $book->price)
        <p>{{ $book->title }}</p>
    @endforeach
    <p>Final cost: {{$finalcost}} €</p>
    <p>State: {{ $purchase->state_purchase }}</p>
    @if (Auth::user()->isAdmin())
        <form method="POST" action="/api/users/{{$purchase->user_id}}/purchases/status">
          <label for="status">Order status:</label><br>
          <select id="status" name="status">
            <option value="Received">Received</option>
            <option value="Dispatched">Dispatched</option>
            <option value="Delivered">Delivered</option>
          </select>
          <input type="hidden" name="purchase_id" value="{{$purchase->id}}">
        </form> 
    @endif
    <p>Arrival date:  {{ $purchase->delivery->arrival }}</p>
    <p>Delivery address:  {{ $purchase->delivery->delivery_address }}</p>
    @php ($final_state = 'Delivered')
    @if ($purchase->state_purchase != $final_state)
        <form method="POST" action="/api/users/{{$purchase->user_id}}/purchases/cancel">
            <input type="hidden" name="purchase_id" value="{{$purchase->id}}">
            <input type="hidden" name="delivery_id" value="{{$purchase->delivery->id}}">
            <input type="submit" value="Cancel order">
        </form>
    @endif
</article>