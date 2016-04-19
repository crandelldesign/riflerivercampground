@extends('master.templates.master')

@section('body')

<h1>River Trips</h1>

<p>There are many fun ways to make it down the beautiful Rifle River. Check them out to see more.</p>
<ul>
    <li><a href="{{url('/river-trips/canoeing')}}">Canoeing</a></li>
    <li><a href="{{url('/river-trips/kayaking')}}">Kayaking</a></li>
    <li><a href="{{url('/river-trips/tubing')}}">Tubing</a></li>
</ul>

<p>Check out our specials <a href="{{url('/river-trips/specials')}}">here</a>.</p>

@stop