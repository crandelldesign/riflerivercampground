@extends('layouts.admin')
@section('content-header')
	<h1>Welcome {{\Auth::user()->name}}</h1>
@stop
@section('content')
	<div class="box">
        <div class="box-body">

        	@if (session('success'))
			    <div class="alert alert-success alert-dismissible fade in">
			    	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <ul>
			            <li>{{session('success')}}</li>
			        </ul>
			    </div>
			@endif

			@if (session('message'))
			    <div class="alert alert-info">
			    	<h4><i class="fa fa-thumbs-up"></i> Message</h4>
			        {{ session('message') }}
			    </div>
			    <hr>
			@endif

			<div class="row">
				<div class="col-md-6 margin-bottom-15"><a href="{{url('/admin/reservations')}}" class="btn btn-lg btn-default btn-block">Check Reservations</a></div>
				<div class="col-md-6 margin-bottom-15"><a href="{{url('/admin/reservations/add')}}" class="btn btn-lg btn-default btn-block">Add New Reservation</a></div>
			</div>
			<hr>
			<div class="row">
				<div class="col-md-4 margin-bottom-15"><a href="{{url('/admin/camping')}}" class="btn btn-lg btn-default btn-block">Edit Camp Sites</a></div>
				<div class="col-md-4 margin-bottom-15"><a href="{{url('/admin/cabins')}}" class="btn btn-lg btn-default btn-block">Edit Cabin Sites</a></div>
				<div class="col-md-4 margin-bottom-15"><a href="{{url('/admin/holidays')}}" class="btn btn-lg btn-default btn-block">Edit Holidays</a></div>
			</div>
		</div>
	</div>
@stop