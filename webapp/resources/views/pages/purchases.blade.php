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
<div id="pWrapper">
    @each('partials.purchase', $purchases, 'purchase')
</div>
{{ $purchases->links() }}
@endsection
