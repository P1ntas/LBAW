@extends('layouts.app')

@section('title', $book->title)

@section('content')
  @include('partials.book_info', [
    'book' => $book, 
    'category' => $category, 
    'publisher' => $publisher, 
    'authors' => $authors,
    'reviews' => $reviews
  ])
@endsection
