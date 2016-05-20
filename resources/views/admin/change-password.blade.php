@extends('layouts.admin')
@section('content-header')
    <h1>Change Password</h1>
@stop
@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="box">
            <div class="box-body">
                <form id="change-password-form" action="{{url('/')}}/admin/change-password" method="post" role="form">
                  	<div class="form-group">
                    	<label for="password">Old Password</label>
                    	<input type="password" class="form-control" id="current_password" name="current_password" placeholder="Enter Old Password">
                    </div>
                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter New Password">
                    </div>
                    <div class="form-group">
                        <label for="password">Confirm New Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm New Password">
                    </div>
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="alert alert-danger alert-dismissible fade in hidden" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                        <h4>Your passwords do not match.</h4>
                    </div>
                    <div class="form-group">
                	   <button type="submit" class="btn btn-primary">Change Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop