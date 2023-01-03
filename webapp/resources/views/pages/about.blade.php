@extends('layouts.app')

@section('notification')
@if (Session::has('notification'))
    <div class="notification {{ Session::get('notification_type') }}">
      {{ Session::get('notification') }}
    </div>
    <button class="close-button" type="button">X</button>
@endif
@endsection

@section('content')
<div id="rowAboutUs">
    <div id="col1AboutUs">
        <p id= "titleAboutUs"><b>How we started</b></p>
        <p id= "story">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed blandit erat in purus luctus, 
            id dictum nisl laoreet. Praesent quis enim dolor. Donec dignissim hendrerit blandit. Sed ut 
            rutrum ipsum. Nunc auctor nisi sed dui tempor rhoncus. Duis augue lacus, feugiat eget erat vitae, 
            dapibus mattis lorem. Nunc nec aliquet sapien. Integer tortor ex, facilisis non ultricies vitae, 
            posuere a ligula. Lorem ipsum dolor sit amet, consectetur adipiscing elit.<br> Nunc sodales urna 
            lorem, non eleifend elit dictum ac. Quisque vulputate eleifend diam ut tincidunt. Nunc tempor, 
            erat sed pellentesque dignissim, leo ante rutrum nulla, eget maximus nisi velit ac lectus. 
        </p>
    </div>
    <div id="col2AboutUs">
        <img id= "imgAboutUs" src="{{ URL::asset('images/bookStore.jpg') }}" id="bookStore">
    </div>
</div>
@endsection