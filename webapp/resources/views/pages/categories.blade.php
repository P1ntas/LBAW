@extends('layouts.app')

@section('notification')
@if (Session::has('notification'))
    <div class="notification {{ Session::get('notification_type') }}">
      {{ Session::get('notification') }}
    </div>
    <button class="close-button" type="button">X</button>
@endif
@endsection

@section('content')
<div class="catWrapper">
    <span class="title"> Categories</span>
    @if (Auth::check() && Auth::user()->isAdmin())
        <form method="POST" action="/categories/add">
            @csrf

            <input type="text" name="name" placeholder="category name">
            @if ($errors->has('name'))
                <span class="error">
                  {{ $errors->first('name') }}
                </span>
            @endif

            <button type="submit">
                <i class="fa-regular fa-plus"></i>
            </button>
        </form>
    @endif
    <ul>
        @each('partials.category', $categories, 'category')
    </ul>
</div>
{{ $categories->links() }}
@endsection