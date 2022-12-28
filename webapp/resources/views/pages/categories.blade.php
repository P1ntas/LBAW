@extends('layouts.app')

@section('title', 'Categories')

@section('content')

@each('partials.category', $categories, 'category')
{{ $categories->links() }}

@endsection