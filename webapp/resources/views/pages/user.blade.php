@extends('layouts.app')

@section('title', $user->name)

@section('content')
  @include('partials.user_info', ['user' => $user])
@endsection
