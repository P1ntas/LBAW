@extends('layouts.app')

@section('name', $user->name)

@section('content')
  @include('partials.user', ['user' => $user])
@endsection
