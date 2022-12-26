@extends('layouts.app')

@section('title', 'FAQ')

@section('content')

<section id="faq">
    @each('partials.faq_info', $faqs, 'faq')
</section>

@endsection
