@extends('layouts.app')

@section('notification')
@if (Session::has('notification'))
    <div class="notification {{ Session::get('notification_type') }}">
      {{ Session::get('notification') }}
    </div>
    <button class="close-button" type="button">X</button>
@endif
@endsection

@section('content')
<form id="fedit" method="POST" action="/books/add">
    @csrf

    <input class="editor" type="text" name="title" placeholder="title" required>
    @if ($errors->has('title'))
      <span class="error">
          {{ $errors->first('title') }}
      </span>
    @endif

    <input class="editor" type="number" name="isbn" placeholder="isbn" required>
    @if ($errors->has('isbn'))
      <span class="error">
          {{ $errors->first('isbn') }}
      </span>
    @endif

    <input class="editor" type="year" name="year" placeholder="year">
    @if ($errors->has('year'))
      <span class="error">
          {{ $errors->first('year') }}
      </span>
    @endif

    <input class="editor" type="number" name="price" min="0.01" max="999.99" step="0.01" placeholder="price">
    @if ($errors->has('price'))
      <span class="error">
          {{ $errors->first('price') }}
      </span>
    @endif

    <input class="editor" type="number" name="stock" min="0" placeholder="stock" required>
    @if ($errors->has('stock'))
      <span class="error">
          {{ $errors->first('stock') }}
      </span>
    @endif

    <input class="editor" type="number" name="book_edition" placeholder="edition">
    @if ($errors->has('book_edition'))
      <span class="error">
          {{ $errors->first('book_edition') }}
      </span>
    @endif

    <input class="editor" type="text" name="book_description" placeholder="description">
    @if ($errors->has('book_description'))
      <span class="error">
          {{ $errors->first('book_description') }}
      </span>
    @endif

    <select class="editor" name="category_name" placeholder="category" required>
      @foreach ($categories as $category)
        <option value="{{ $category->name }}">{{ $category->name }}</option>
      @endforeach
    </select>
    @if ($errors->has('category_name'))
      <span class="error">
          {{ $errors->first('category_name') }}
      </span>
    @endif

    <select class="editor" name="publisher_name" placeholder="publisher">
      @foreach ($publishers as $publisher)
        <option value="{{ $publisher->name }}">{{ $publisher->name }}</option>
      @endforeach
    </select>
    @if ($errors->has('publisher_name'))
      <span class="error">
          {{ $errors->first('publisher_name') }}
      </span>
    @endif

    <input class="editor" type="text" name="authors" placeholder="author(s) - separate multiple with /" required>
    @if ($errors->has('authors'))
      <span class="error">
          {{ $errors->first('authors') }}
      </span>
    @endif

    <button id="edit_button" class="edit_button" type="submit">Add book</button>
</form>
@endsection