@extends('layouts.app')

@section('title', $user->name)

@section('content')
  @include('partials.edit_user', ['user' => $user])
@endsection
