@extends('layouts.app')

@section('title', 'Purchase History')

@section('content')

<section id="purchases">
  <p>Purchase History</p>
  @each('partials.purchase', $purchases, 'purchase')
</section>

@endsection
