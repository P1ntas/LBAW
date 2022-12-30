@extends('layouts.app')

@section('title', 'Purchases')

@section('content')

<div id="pWrapper">
    @each('partials.purchase', $purchases, 'purchase')
</div>
{{ $purchases->links() }}

@endsection
