<div class="card card1 collection1">
    <!-- collection_photo -->
    <a href="/collections/{{ $collection->id }}"><p>{{ $collection->name}}</p></a>
    @php ($final_cost = 0)
    @foreach ($collection->books as $book)
        @php ($final_cost += $book->price)
    @endforeach
    <p class="unbold">Books: <span>{{ count($collection->books) }}</span></p>
    <p class="price">Price: <span>{{ $final_cost }} €</span><p>
</div>