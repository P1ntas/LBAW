@extends('layouts.app')

@section('name', $user->name)

@section('content')
  @include('partials.edit_user', ['user' => $user])
@endsection
