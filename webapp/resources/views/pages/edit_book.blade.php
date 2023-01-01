@extends('layouts.app')

@section('title', '$book->title')

@section('content')

<h1>Edit Book</h1>
<div id="editWrapper">
    <!-- book_photo -->
    <br/>
    <form method="POST" action="/books/{{ $book->id }}/remove">
        @csrf
        @method('DELETE')
        <button type="submit" id="delete_button" class="edit_button">Remove book</button>
    </form>
</div>
<form id="fedit" method="POST" action="/books/{{ $book->id }}/edit">
    @csrf
    @method('PUT')

    <label for="title">Title *</label>
    <input id="title" class="editor" type="text" name="title" value="{{ $book->title }}" required>
    @if ($errors->has('title'))
      <span class="error">
          {{ $errors->first('title') }}
      </span>
    @endif

    <label for="isbn">ISBN *</label>
    <input id="isbn" class="editor" type="number" name="isbn" value="{{ $book->isbn }}" required>
    @if ($errors->has('isbn'))
      <span class="error">
          {{ $errors->first('isbn') }}
      </span>
    @endif

    <label for="year">Year</label>
    <input id="year" class="editor" type="year" name="year" value="{{ $book->year }}">
    @if ($errors->has('year'))
      <span class="error">
          {{ $errors->first('year') }}
      </span>
    @endif

    <label for="price">Price *</label>
    <input id="price" class="editor" type="number" name="price" min="0.01" max="999.99" step="0.01" value="{{ $book->price }}">
    @if ($errors->has('price'))
      <span class="error">
          {{ $errors->first('price') }}
      </span>
    @endif

    <label for="stock">Stock *</label>
    <input id="stock" class="editor" type="number" name="stock" min="0" value="{{ $book->stock }}" required>
    @if ($errors->has('stock'))
      <span class="error">
          {{ $errors->first('stock') }}
      </span>
    @endif

    <label for="book_edition">Edition</label>
    <input id="book_edition" class="editor" type="number" name="book_edition" value="{{ $book->book_edition }}">
    @if ($errors->has('book_edition'))
      <span class="error">
          {{ $errors->first('book_edition') }}
      </span>
    @endif

    <label for="book_description">Description</label>
    <input id="book_description" class="editor" type="text" name="book_description" value="{{ $book->book_description }}">
    @if ($errors->has('book_description'))
      <span class="error">
          {{ $errors->first('book_description') }}
      </span>
    @endif

    <label for="category_name">Category *</label>
    <select id="category_name" class="editor" name="category_name" required>
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
    <select id="publisher_name" class="editor" name="publisher_name">
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
    <input id="authors" class="editor" type="text" name="authors" value="{{ $authors }}" required>
    @if ($errors->has('authors'))
      <span class="error">
          {{ $errors->first('authors') }}
      </span>
    @endif

    <button type="submit" id="edit_button" class="edit_button">Confirm changes</button> 
</form> 


@endsection