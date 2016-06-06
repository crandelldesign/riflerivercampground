@extends('layouts.admin')
@section('content-header')
    <h1>Holiday Weekends</h1>
@stop
@section('content')
<div class="row">
    <div class="col-lg-10">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade in">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <ul>
                    <li>{{session('success')}}</li>
                </ul>
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

        <form method="post" action="{{url('/admin/holidays')}}" class="form-horizontal">
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
                            <div class="input-group date">
                                <input class="form-control date" name="starts_at" type="text" placeholder="##/##/####" value="{{old('starts_at')?old('starts_at'):''}}">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3">End Date</label>
                        <div class="col-sm-5">
                            <div class="input-group date">
                                <input class="form-control date" name="ends_at" type="text" placeholder="##/##/####" value="{{old('ends_at')?old('ends_at'):''}}">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="box-footer text-right">
                    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                    <input class="btn btn-default" type="submit" value="Save">
                </div>
            </div>
        </form>

        <div class="box">
            <div class="box-header with-border">
                <h2 class="box-title">Upcoming Holidays</h2>
            </div>
            <div class="box-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width: 30%">Title</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($holidays as $holiday)
                        <tr>
                        <form method="post" action="{{url('/admin/holidays')}}">
                            <td><input type="text" class="form-control" name="holiday_title" placeholder="Holiday Title" value="{{$holiday->title}}"></td>
                            <td>
                                <div class="input-group date">
                                    <input class="form-control date" name="starts_at" type="text" placeholder="##/##/####" value="{{date('m/d/Y', strtotime($holiday->starts_at))}}">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </td>
                            <td>
                                <div class="input-group date">
                                    <input class="form-control date" name="ends_at" type="text" placeholder="##/##/####" value="{{date('m/d/Y', strtotime($holiday->ends_at))}}">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </td>
                            <td>
                                <input type="hidden" name="holiday_id" value="{{$holiday->id}}">
                                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                                <input class="btn btn-default" type="submit" value="Update">
                            </td>
                        </form>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

@stop
@section('scripts')
<script>
    $(document).ready(function(){
        $('.input-group.date').datetimepicker({
            allowInputToggle: true,
            format: 'M/D/YYYY'
        });
    });
</script>
@stop