@extends('layouts.default')

@section('subhead')
<div class="subhead">
    <h1>Peaceful Camping and Canoeing in beautiful Sterling, MI</h1>
    <div>
        <a href="{{url('/park-map')}}" class="btn btn-blue btn-lg">See Our Campground</a>
        <div class="clearfix visible-xs-block"></div>
        <a href="{{url('/contact')}}" class="btn btn-green btn-lg">Contact Us</a>
    </div>
</div>
@stop

@section('content')

<h1>Welcome to Rifle River Campground</h1>

<p class="text-center"><img class="img-responsive center-block" src="{{url('/img/homepage.jpg')}}" alt="homepage" width="1920" height="700"></p>

<p>Rifle River Campground &amp; Canoe Livery, LLC is located in Sterling, MI along the beautiful Rifle River. We offer camping both modern and rustic camping with over 25 campsites directly on the river. Whether you prefer to enjoy to serenity of the river in one of our canoes, tubes or kayaks or simply want to explore nature, we have what you need to enjoy your camping experience.</p>

<h2><a href="https://www.facebook.com/RifleRiverCampground" target="_blank"><i class="fa fa-facebook-square"></i> Find us on Facebook</a></h2>

<h2>Specials</h2>
<h3>Midweek special</h3>
<p>$5.00 off per person on all river trips. 5 or more rentals — 1/2 off!<br>
    <small>*rates valid Monday through Friday</small></p>

@stop