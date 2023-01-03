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
            Off The Shelf started simply as a dream for us. We started this project we were still in 
            highscool and decided to finally commence a small business that sold books in its majority.
            The garage was our first selling spot for books and although the beggining was very hard, we 
            didn't give up. </br> Few years later we got our first considerable profit and and some months 
            after that, we opened up our first store. At the moment, we already have a website solely made for 
            books and we couldn't be more proud for what we have done along this path. To be in the scale we are now 
            we can only thank our customers who made this possible and helped us improve this business every day.
        </p>
    </div>
    <div id="col2AboutUs">
        <img id= "imgAboutUs" src="{{ URL::asset('images/bookStore.jpg') }}" id="bookStore">
    </div>
</div>
@endsection
