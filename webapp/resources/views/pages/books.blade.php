@extends('layouts.app')

@section('title', 'Books')

@section('content')

<section id="books">
  <label for="search">Search</label>
  <form method="POST" action="/api/books/search">
    {{ csrf_field() }}
    <input type="text" name="search" placeholder="Search for a book">
  </form>
  <form method="POST" action="/api/books/filter">
    <label for="category_name">Category</label>
    <select id="category_name" name="category_name" required>
      @foreach ($categories as $category)
        <option value="{{ $category->name }}">{{ $category->name }}</option>
      @endforeach
    </select>
    @if ($errors->has('category_name'))
      <span class="error">
          {{ $errors->first('category_name') }}
      </span>
    @endif

    <label for="price">Price:</label>
    <input type="number" id="price-min" name="price_min" min="0" step="0.01" placeholder="Min">
    <input type="number" id="price-max" name="price_max" min="0" step="0.01" placeholder="Max">
  </form>
  @if (Auth::user()->isAdmin())
    <a href="/books/add">Add a new book</a>
  @endif
  @each('partials.book', $books, 'book')
</section>

@endsection
