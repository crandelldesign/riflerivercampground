@extends('layouts.default')

@section('head')
<script src='https://www.google.com/recaptcha/api.js'></script>
@stop

@section('content')
<h1>Reservations</h1>

<p>Book your reservation today.</p>

<form action="{{url('/reservations')}}" method="post">
    <div class="row">
        <div class="col-sm-6 col-md-4">
            <div class="form-group">
                <label>From</label>
                <div class="input-group date" id="starts_at">
                    <input class="form-control date" name="starts_at" type="text" placeholder="##/##/####" value="{{old('starts_at')?old('starts_at'):isset($starts_at)?date('m/d/Y',$starts_at):''}}">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="form-group">
                <label>To</label>
                <div class="input-group date" id="ends_at">
                    <input class="form-control date" name="ends_at" type="text" placeholder="##/##/####" value="{{old('ends_at')?old('ends_at'):isset($ends_at)?date('m/d/Y',$ends_at):''}}">
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
                    <option value="camping">Camping</option>
                    <option value="cabin">Cabin</option>
                </select>
            </div>
        </div>
        <div class="col-sm-6 col-md-4 type-col" style="{{(isset($what) && $what == 'cabin')?'display:none':''}}">
            <div class="form-group">
                <label>Type</label>
                <select name="type" class="form-control select-type">
                    <option value="rustic">Rustic</option>
                    <option value="modern">Modern</option>
                </select>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="form-group">
                <label>Site</label>
                <select name="site_id" class="form-control select-type">
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
                <label>Children</label>
                <select name="children_count" class="form-control">
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
                <label>Name:</label>
                <input type="text" name="name" value="{{old('name')}}" size="40" class="form-control" aria-required="true" aria-invalid="false" placeholder="Name">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group form-group {{(count($errors) > 0 && $errors->first('email'))?'has-error':''}}">
                <label>Email Address:</label>
                <input type="email" name="email" value="{{old('email')}}" size="40" class="form-control" aria-required="true" aria-invalid="false" placeholder="Email">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="control-group form-group {{(count($errors) > 0 && $errors->first('phone'))?'has-error':''}}">
                <label>Phone Number:</label>
                <input type="tel" name="phone" value="{{old('phone')}}" size="40" class="form-control" aria-required="true" aria-invalid="false" placeholder="Phone Number">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group form-group">
                <label>Best Time to Call:</label>
                <input type="text" name="best_time" value="{{old('best_time')}}" size="40" class="form-control" aria-required="true" aria-invalid="false" placeholder="ex: 5:00pm">
            </div>
        </div>
    </div>
    <div class="control-group form-group {{(count($errors) > 0 && $errors->first('message'))?'has-error':''}}">
        <label>Message:</label>
        <textarea name="message" cols="40" rows="10" class="form-control" aria-required="true" aria-invalid="false">{{old('message')}}</textarea>
    </div>
    <div class="control-group form-group {{(count($errors) > 0 && $errors->first('name'))?'has-error':''}}">
        <div class="g-recaptcha" data-sitekey="6Le-iwwTAAAAAISVouN7lSSZJ6f_r2hL6rwDG0w3"></div>
    </div>
    <div class="control-group form-group">
        {!! csrf_field() !!}
        <button type="submit" value="Send" class="btn btn-blue">Submit</button>
    </div>
</form>

@stop

@section('scripts')
<script>
    $(document).ready(function()
    {
        $('.select-what').on('change', function(event)
        {
            if ($(this).val() == 'camping')
            {
                $('.type-col').show();

            } else {
                $('.type-col').hide();
            }
        });

        $('.select-type').on('change', function(event)
        {

        });

        function checkAvailability()
        {
            
        }
    });
</script>
@stop
