@extends('layouts.app')

@section('title', 'Contacts')

@section('content')

<div id="ContactUs">
    <div class="mapouter"><div class="gmap_canvas"><iframe class="gmap_iframe" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=600&amp;height=400&amp;hl=en&amp;q=R. Dr. Roberto Frias, 4200-465 Porto&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe><a href="https://www.gachacute.com/">www.gachacute.com</a></div><style>.mapouter{position:relative;text-align:right;width:600px;height:400px;}.gmap_canvas {overflow:hidden;background:none!important;width:600px;height:400px;}.gmap_iframe {width:600px!important;height:400px!important;}</style></div>
    <div id="contacts">
        <p>Email: <span>offtheshelf@gmail.com</span></p>
        <p>Address: <span>Rua dos berdadeiros, 456, Porto Portugal</span></p>
        <p>Phone number: <span>934 342 434</span></p>
    </div>
</div>

@endsection