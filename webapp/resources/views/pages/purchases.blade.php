@extends('layouts.app')

@section('title', 'Purchase History')

@section('content')

<section id="purchases">
  @each('partials.purchase', $purchases, 'purchase')
</section>

@endsection
