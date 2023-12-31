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
<script>
  document.addEventListener("DOMContentLoaded", function() {
    register();
  });
</script>
<div id="login">
  <div class="formul">
      <div class="button_rectangle">
        <div id="log"></div>
        <button type="button" id="log1" class="button_log" onclick="login()">Login</button>
        <button type="button" id="log2" class="button_log" onclick="register()">Register</button>
      </div>
      @include('auth.sign_in')
      @include('auth.sign_up')
  </div>
</div>
@endsection