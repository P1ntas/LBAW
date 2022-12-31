@extends('layouts.app')

@section('title', 'Books')

@section('content')

<form method="POST" action="/books/filter">
    @csrf

    <label for="category">Category</label>
    <select id="category" name="category">
        @empty($category)
            <option value="" disabled selected>[All]</option>
            @foreach ($categories as $c)
                <option value="{{ $c->name }}">{{ $c->name }}</option>
            @endforeach
        @else
            @foreach ($categories as $c)
                @if ($c->name == $category)
                    <option value="{{ $c->name }}" selected>{{ $c->name }}</option>
                @else
                    <option value="{{ $c->name }}">{{ $c->name }}</option>
                @endif
            @endforeach
        @endempty
    </select>

    <label for="price_min">Price (Min):</label>
    @empty($price_min)
        <input type="number" id="price-min" name="price_min" value="0.00" min="0.01" max="999.99" step="0.01" placeholder="Min">
    @else
        <input type="number" id="price-min" name="price_min" value="{{ $price_min }}" min="0.01" max="999.99" step="0.01" placeholder="Min">
    @endempty

    <label for="price_max">Price (Max):</label>
    @empty($price_max)
        <input type="number" id="price-max" name="price_max" value="120.00" min="0.00" max="120.00" step="0.01" placeholder="Max">
    @else
        <input type="number" id="price-max" name="price_max" value="{{ $price_max }}" min="0.00" max="120.00" step="0.01" placeholder="Max">
    @endempty

    <input type="submit" value="Apply filters">
</form>
@each('partials.book', $books, 'book')
{{ $books->links() }}

@endsection