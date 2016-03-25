@extends('master.templates.master')

@section('subheader')
<div class="subhead">
    <h1>Peaceful Camping and Canoeing in beautiful Sterling, MI</h1>
    <div>
        <a href="{{url('/')}}/park-map" class="btn btn-blue btn-lg">See Our Campground</a>
        <div class="clearfix visible-xs-block"></div>
        <a href="{{url('/')}}/contact" class="btn btn-green btn-lg">Contact Us</a>
    </div>
</div>
@stop

@section('body')

<h1>Welcome</h1>

@stop