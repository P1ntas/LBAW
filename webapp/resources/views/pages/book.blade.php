@extends('layouts.app')

@section('title', $book->title)

@section('content')
  @include('partials.book_info', [
    'book' => $book
  ])
@endsection
