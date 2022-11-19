@extends('layouts.app')

@section('title', $admin->name)

@section('content')
  @include('partials.admin_info', ['admin' => $admin])
@endsection
