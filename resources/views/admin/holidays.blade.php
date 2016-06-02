@extends('layouts.admin')
@section('content-header')
    <h1>Holiday Weekends</h1>
@stop
@section('content')
<div class="row">
    <div class="col-lg-10">
        <form class="form-horizontal">
            <div class="box">
                <div class="box-header with-border">
                    <h2 class="box-title">Add Holiday Weekends</h2>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label class="control-label col-sm-3">Holiday Title</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="holiday_title" placeholder="Holiday Title" value="{{old('holiday_title')?old('holiday_title'):''}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3">Start Date</label>
                        <div class="col-sm-5">
                            <div class="input-group date" id="event_date_group">
                                <input class="form-control date" name="starts_at" type="text" placeholder="##/##/####" value="{{old('starts_at')?old('starts_at'):''}}">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3">End Date</label>
                        <div class="col-sm-5">
                            <div class="input-group date" id="event_date_group">
                                <input class="form-control date" name="ends_at" type="text" placeholder="##/##/####" value="{{old('ends_at')?old('ends_at'):''}}">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="box-footer text-right">
                    <input class="btn btn-default" type="submit" value="Save">
                </div>
            </div>
        </form>
    </div>
</div>

@stop
@section('scripts')
<script>
    $(document).ready(function(){
        $('#event_date_group').datetimepicker({
            allowInputToggle: true,
            format: 'M/D/YYYY'
        });
    });
</script>
@stop