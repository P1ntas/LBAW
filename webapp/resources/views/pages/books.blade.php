@extends('layouts.app')

@section('title', 'Purchases')

@section('content')

<section id="books">
  @each('partials.book', $books, 'book')
</section>

@endsection
