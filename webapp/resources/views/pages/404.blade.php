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
<div class="redWrapper">
  <img src="{{ URL::asset('images/cat.jpg') }}" alt="redirectPhoto" id="catP">
  <p>You didn't find what you were looking for, but you found Morena.</p>
  <p>She needs a new home. If you'd like to adopt her, please contact the owners of this site.</p>
</div>
@endsection