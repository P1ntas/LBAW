@extends('layouts.app')

@section('title', $admin->name)

@section('content')
  @include('partials.edit_admin', ['admin' => $admin])
@endsection
