@extends('layouts.app')

@section('title', $book->title)

@section('content')
  @include('partials.edit_book', [
    'book' => $book
  ])
@endsection