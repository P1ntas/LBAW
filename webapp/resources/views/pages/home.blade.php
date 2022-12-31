@extends('layouts.app')

@section('title', 'Home')

@section('content')

<div class="homePage">
    <div id="books">
        <span>Books</span>
        @if (Auth::check() && Auth::user()->isAdmin())
            <span>
                <a href="/books/add"><i class="fa-regular fa-plus"></i> Book</a>
            </span>
        @endif
        <a href="/books"><span>View all >></span></a>
    </div>
    <div class="books">
        <!-- books -->
    </div>
    <div id="books">
        <span>Collections</span>
        <a href="/"><span class="pos">View all >></span></a>
    </div>
    <div class="books">
        <!-- collections -->
    </div>
</div>


@endsection