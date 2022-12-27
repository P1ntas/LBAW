@extends('layouts.app')

@section('title', 'Categories')

@section('content')

<section id="categories">
  <label for="search">Search</label>
  <form method="POST" action="/api/categories/search">
    {{ csrf_field() }}
    <input type="text" name="search" placeholder="Search for a category">
  </form>
  @each('partials.category', $categories, 'category')
</section>

@endsection
