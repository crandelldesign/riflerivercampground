@extends('layouts.default')

@section('content')
<h1>Reservations</h1>

<p>Book your reservation today.</p>

<form>
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
