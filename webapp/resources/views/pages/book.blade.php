@extends('layouts.app')

@section('title', $book->title)

@section('content')
  @include('partials.book', ['book' => $book])
@endsection
