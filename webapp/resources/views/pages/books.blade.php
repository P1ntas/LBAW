@extends('layouts.app')

@section('title', 'Books')

@section('content')

<section id="books">
  @each('partials.book', $books, 'book')
</section>

@endsection
