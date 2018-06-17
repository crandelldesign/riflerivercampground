@extends('layouts.default')

@section('head')
<meta name="p:domain_verify" content="b8938f241778236bd948d7ff51ef938b"/>
@stop

@section('subhead')
<div class="subhead">
    <h1>Peaceful Camping and Canoeing in beautiful Sterling, MI</h1>

    <?php $reservation_front_end = env('RESERVATION_FRONT_END', false) ?>
    @if ($reservation_front_end)
    <div class="reservation">
        <h2>Schedule Your Vacation Today</h2>
        <form class="form-inline" action="{{url('/subhead-reservation')}}" method="post">
            <div class="form-group">
                <label>From</label>
                <div class="input-group date" id="subhead_starts_at">
                    <input class="form-control date" name="starts_at" type="text" placeholder="{{date('n/d/Y')}}" value="{{old('starts_at')?old('starts_at'):''}}">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
            </div>
            <div class="form-group">
                <label>To</label>
                <div class="input-group date" id="subhead_ends_at">
                    <input class="form-control date" name="ends_at" type="text" placeholder="{{date('n/d/Y',strtotime('+3 days'))}}" value="{{old('ends_at')?old('ends_at'):''}}">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
            </div>
            <div class="form-group">
                <label>What</label>
                <select name="what" class="form-control">
                    <option value="CampSite">Camping</option>
                    <option value="CabinSite">Cabin</option>
                </select>
            </div>
            <div class="form-group">
                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                <button type="submit" class="btn btn-blue">Check Availability</button>
            </div>
        </form>
    </div>
    @endif

    <!--<div>
        <a href="{{url('/park-map')}}" class="btn btn-blue btn-lg">See Our Campground</a>
        <div class="clearfix visible-xs-block"></div>
        <a href="{{url('/contact')}}" class="btn btn-green btn-lg">Contact Us</a>
    </div>-->
</div>
@stop

@section('content')

<h1>Welcome to Rifle River Campground</h1>

@if ( strtotime('10/17/2016') > strtotime('now') )
<div class="zombie-on-the-river-container">
    <h2 class="text-center">Zombie on the River</h2>
    <h3 class="text-center">Haunted Camping Weekend</h3>
    <p class="text-center lead"><strong>October 14-16</strong></p>
    <div class="row">
        <div class="col-sm-6">
            <ul>
                <li>Haunted Hay Ride like no other!</li>
                <li>Zombie Movie Night</li>
                <li>DJ Saturday Night</li>
            </ul>
        </div>
        <div class="col-sm-6">
            <ul>
                <li>Costume Contest</li>
                <li>Creepiest Campsite Contest</li>
            </ul>
        </div>
    </div>
    <p class="text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Prizes for best costume &amp; best spookiest campsite include a free weekend stay!</p>
    <address>Rifle River Campground &amp; Canoe Livery<br>
        5825 N Townline Rd, Sterling, MI 48659<br>
        989-654-2556</address>
    <p><small><a href="mailto:reservations@riflerivercampground.com">reservations@riflerivercampground.com</a></small></p>
</div>
@else
<p class="text-center"><img class="img-responsive center-block" src="{{url('/img/homepage.jpg')}}" alt="homepage" width="1920" height="700"></p>
@endif

<p>Rifle River Campground &amp; Canoe Livery, LLC is located in Sterling, MI along the beautiful Rifle River. We offer camping both modern and rustic camping with over 25 campsites directly on the river. Whether you prefer to enjoy to serenity of the river in one of our canoes, tubes or kayaks or simply want to explore nature, we have what you need to enjoy your camping experience.</p>

<h2><a href="https://www.facebook.com/RifleRiverCampground" target="_blank"><i class="fa fa-facebook-square"></i> Find us on Facebook</a></h2>

<h2>Specials</h2>
<h3>Midweek special</h3>
<p>$5.00 off per person on all river trips. 5 or more rentals — 1/2 off!<br>
    <small>*rates valid Monday through Thursday Excluding holidays</small></p>

@stop

@section('scripts')
<script>
    $(document).ready(function()
    {
        $('#subhead_starts_at').datetimepicker({
            allowInputToggle: true,
            format: 'M/D/YYYY'
        });
        $('#subhead_ends_at').datetimepicker({
            useCurrent: false, //Important! See issue #1075
            allowInputToggle: true,
            format: 'M/D/YYYY'
        });
        $("#subhead_starts_at").on("dp.change", function (e) {
            checkMinimumStay($(this).find('input').val());
            $('#subhead_ends_at').data("DateTimePicker").minDate(e.date);

        });
        $("#subhead_ends_at").on("dp.change", function (e) {
            //$('#subhead_starts_at').data("DateTimePicker").maxDate(e.date);
        });

    });
    function updatesEndsAt(days)
    {
        $('#subhead_ends_at input').val(moment($("#subhead_starts_at input").val(),'M/D/YYYY').add(days,'days').format('M/D/YYYY'));
    }
</script>
@stop
