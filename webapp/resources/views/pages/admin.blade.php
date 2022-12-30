@extends('layouts.app')

@section('title', $admin->name)

@section('content')

<h1>{{ $admin->name }}</h1>
<div id="editWrapper">
    <!-- user_photo -->
</div>
<div class="profileWrapper1">
    <p>Email: <span>{{ $admin->email }}</span></p> 
    <p>Address: <span>{{ $admin->user_address }}</span></p>
    @if (!empty($admin->phone))
        <p>Phone Number: <span>{{ $admin->phone }}</span></p>
    @endif
</div>

@endsection
