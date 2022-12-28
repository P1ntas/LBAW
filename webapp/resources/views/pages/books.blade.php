@extends('layouts.app')

@section('title', 'Contacts')

@section('content')

@each('partials.book', $books, 'book')
{{ $books->links() }}

@endsection