@extends('layouts.app')

@section('title', 'Add Book')

@section('content')
  
<form method="POST" action="/books/add">
    @csrf

    <label for="title">Title *</label>
    <input id="title" type="text" name="title" required>
    @if ($errors->has('title'))
      <span class="error">
          {{ $errors->first('title') }}
      </span>
    @endif

    <label for="isbn">ISBN *</label>
    <input id="isbn" type="number" name="isbn" required>
    @if ($errors->has('isbn'))
      <span class="error">
          {{ $errors->first('isbn') }}
      </span>
    @endif

    <label for="year">Year</label>
    <input id="year" type="year" name="year">
    @if ($errors->has('year'))
      <span class="error">
          {{ $errors->first('year') }}
      </span>
    @endif

    <label for="price">Price *</label>
    <input id="price" type="number" name="price" min="0.01" max="999.99" step="0.01">
    @if ($errors->has('price'))
      <span class="error">
          {{ $errors->first('price') }}
      </span>
    @endif

    <label for="stock">Stock *</label>
    <input id="stock" type="number" name="stock" min="0" required>
    @if ($errors->has('stock'))
      <span class="error">
          {{ $errors->first('stock') }}
      </span>
    @endif

    <label for="book_edition">Edition</label>
    <input id="book_edition" type="number" name="book_edition">
    @if ($errors->has('book_edition'))
      <span class="error">
          {{ $errors->first('book_edition') }}
      </span>
    @endif

    <label for="book_description">Description</label>
    <input id="book_description" type="text" name="book_description">
    @if ($errors->has('book_description'))
      <span class="error">
          {{ $errors->first('book_description') }}
      </span>
    @endif

    <label for="category_name">Category *</label>
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

    <label for="publisher_name">Publisher</label>
    <select id="publisher_name" name="publisher_name">
      @foreach ($publishers as $publisher)
        <option value="{{ $publisher->name }}">{{ $publisher->name }}</option>
      @endforeach
    </select>
    @if ($errors->has('publisher_name'))
      <span class="error">
          {{ $errors->first('publisher_name') }}
      </span>
    @endif

    <label for="authors">Author(s) *</label>
    <input id="authors" type="text" name="authors" placeholder="separate multiple authors with /" required>
    @if ($errors->has('authors'))
      <span class="error">
          {{ $errors->first('authors') }}
      </span>
    @endif

    <p>Fields marked with * must be filled.</p>

    <button type="submit">Add book</button>
    <a class="button button-outline" href="/books">Cancel</a>
</form>

@endsection