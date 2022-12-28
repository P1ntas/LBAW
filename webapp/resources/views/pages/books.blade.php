@extends('layouts.app')

@section('title', 'Books')

@section('content')

@empty($category)
    <p>Category: [All]</p>
@else
    <p>Category: [{{ $category }}]</p>
@endempty
@each('partials.book', $books, 'book')
{{ $books->links() }}

@endsection