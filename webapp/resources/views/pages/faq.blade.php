@extends('layouts.app')

@section('title', 'FAQ')

@section('content')

<div id="FAQWrapper">
    @each('partials.faq', $faqs, 'faq')
</div>

@endsection