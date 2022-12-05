@extends('layouts.app')

@section('title', 'FAQ')

@section('content')

@each('partials.faq_info', $faqs, 'faq')

@endsection