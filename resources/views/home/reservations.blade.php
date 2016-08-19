@extends('layouts.default')

@section('head')
<script src='https://www.google.com/recaptcha/api.js'></script>
@stop

@section('content')
<h1>Reservations</h1>

<p>Book your reservation today.</p>

<div class="alert alert-danger alert-no-sites" role="alert" style="{{count($available_spots) != 0?'display:none':''}}">
    <p>We're sorry but there are no sites available for your selection. Please make another selection.</p>
</div>

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

@if (count($errors) > 0)
    <div class="alert alert-danger alert-dismissible fade in">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{url('/reservations')}}" method="post">
    <div class="row">
        <div class="col-sm-6 col-md-4">
            <div class="form-group">
                <label>From</label>
                <div class="input-group date" id="starts_at">
                    <input class="form-control date" name="starts_at" type="text" placeholder="{{date('m/d/Y')}}" value="{{old('starts_at')?old('starts_at'):isset($starts_at)?date('m/d/Y',$starts_at):''}}">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="form-group">
                <label>To</label>
                <div class="input-group date" id="ends_at">
                    <input class="form-control date" name="ends_at" type="text" placeholder="{{date('m/d/Y',strtotime('+3 days'))}}" value="{{old('ends_at')?old('ends_at'):isset($ends_at)?date('m/d/Y',$ends_at):''}}">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-md-4">
            <div class="form-group">
                <label>What</label>
                <select name="what" class="form-control select-what">
                    <option {{old('what')?old('what'):(isset($what) && $what == 'CampSite'?'selected':'')}} value="CampSite">Camping</option>
                    <option {{old('what')?old('what'):(isset($what) && $what == 'CabinSite'?'selected':'')}} value="CabinSite">Cabin</option>
                </select>
            </div>
        </div>
        <div class="col-sm-6 col-md-4 type-col" style="{{(isset($what) && $what == 'CabinSite')?'display:none':''}}">
            <div class="form-group">
                <label>Type</label>
                <select name="type" class="form-control select-type">
                    <option value="rustic">Rustic</option>
                    <option value="electric">Electric</option>
                    <option value="electric-water">Electric &amp; Water</option>
                </select>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="form-group">
                <label>Sites Available</label>
                <select name="site_id" class="form-control" id="site-id" {{count($available_spots) == 0?'disabled':''}}>
                    @foreach ($available_spots as $site)
                        <option value="{{$site->site_id}}">{{$site->site_id}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Adults</label>
                <select name="adult_count" class="form-control">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                </select>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Children <small>(Ages 6-15)</small></label>
                <select name="children_count" class="form-control">
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="control-group form-group {{(count($errors) > 0 && $errors->first('name'))?'has-error':''}}">
                <label>Name</label>
                <input type="text" name="name" value="{{old('name')}}" size="40" class="form-control" aria-required="true" aria-invalid="false" placeholder="Name">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group form-group {{(count($errors) > 0 && $errors->first('email'))?'has-error':''}}">
                <label>Email Address</label>
                <input type="email" name="email" value="{{old('email')}}" size="40" class="form-control" aria-required="true" aria-invalid="false" placeholder="Email">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="control-group form-group {{(count($errors) > 0 && $errors->first('phone'))?'has-error':''}}">
                <label>Phone Number</label>
                <input type="tel" name="phone" value="{{old('phone')}}" size="40" class="form-control" aria-required="true" aria-invalid="false" placeholder="Phone Number">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group form-group">
                <label>Best Time to Call</label>
                <input type="text" name="best_time" value="{{old('best_time')}}" size="40" class="form-control" aria-required="true" aria-invalid="false" placeholder="ex: 5:00pm">
            </div>
        </div>
    </div>
    <div class="control-group form-group {{(count($errors) > 0 && $errors->first('comment'))?'has-error':''}}">
        <label>Comments</label>
        <textarea name="comment" cols="40" rows="3" class="form-control" aria-required="true" aria-invalid="false">{{old('comment')}}</textarea>
    </div>
    <div class="control-group form-group {{(count($errors) > 0 && $errors->first('name'))?'has-error':''}}">
        <div class="g-recaptcha" data-sitekey="6Le-iwwTAAAAAISVouN7lSSZJ6f_r2hL6rwDG0w3"></div>
    </div>
    <div class="control-group form-group">
        {!! csrf_field() !!}
        <button type="submit" value="Send" class="btn btn-blue">Submit</button>
    </div>
</form>

<script id="site-template" type="text/x-handlebars-template">
    @{{#each data}}
    <option value="@{{site_id}}">@{{site_id}}</option>
    @{{/each}}
</script>

@stop

@section('scripts')
<script>
    $(document).ready(function()
    {
        $('#starts_at').datetimepicker({
            allowInputToggle: true,
            format: 'M/D/YYYY'
        });
        $('#ends_at').datetimepicker({
            useCurrent: false, //Important! See issue #1075
            allowInputToggle: true,
            format: 'M/D/YYYY'
        });
        $("#starts_at").on("dp.change", function (e) {
            $('#ends_at').data("DateTimePicker").minDate(e.date);
            $('#subhead_ends_at input').val(moment($("#subhead_starts_at input").val(),'M/D/YYYY').add(2,'days').format('M/D/YYYY'));
        });
        $("#ends_at").on("dp.change", function (e) {
            $('#starts_at').data("DateTimePicker").maxDate(e.date);
        });
        $('.select-what').on('change', function(event)
        {
            if ($(this).val() == 'CampSite')
            {
                $('.type-col').show();

            } else {
                $('.type-col').hide();
            }
            checkAvailability();
        });

        $('.select-type').on('change', function(event)
        {
            checkAvailability();
        });

        function checkAvailability()
        {
            $('#site-id').prop('disabled', true);
            var availabilityObject =  new Object;
            availabilityObject.starts_at = $("#starts_at input").val();
            availabilityObject.ends_at = $("#ends_at input").val();
            availabilityObject.what = $('.select-what').val();
            availabilityObject.type = $('.select-type').val();
            $.ajax({
                url: '{{url("/api/reservation-availability")}}',
                type: 'GET',
                data: availabilityObject,
                success: function(data) {
                    if (JSON.parse(data).length === 0) {
                        $('.alert-no-sites').show();
                    } else {
                        $('.alert-no-sites').hide();
                        $('#site-id').prop('disabled', false);
                    }
                    console.log(data);
                    var source = $("#site-template").html();
                    var template = Handlebars.compile(source);
                    var html = template({
                        data: JSON.parse(data)
                    });
                    $('#site-id').html(html);
                }
            });
        }
    });
</script>
@stop
