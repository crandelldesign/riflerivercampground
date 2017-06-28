@extends('layouts.admin')
@section('content-header')
    @if (isset($reservation))
    <h1>Reservation # {{$reservation->id}} - {{date('n/j/Y',strtotime($reservation->starts_at))}} - {{$reservation->contact_name}}</h1>
    @else
    <h1>Add Reservation</h1>
    @endif
@stop
@section('content')

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

<div class="alert alert-success alert-users-notified" style="display:none">
    <p>The user has been notified of their reservation.</p>
</div>

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

@if (isset($reservation))
<div class="box">
    <div class="box-body">

        <div class="text-center">
            <button class="btn btn-lg btn-primary" data-toggle="modal" data-target="#check-in-modal">Check{{$reservation->is_checked_in?'ed':''}} In</button>
            <button class="btn btn-lg btn-success" data-toggle="modal" data-target="#approve-reject-modal">Approve / Reject</button>
            <button class="btn btn-lg btn-info" data-toggle="modal" data-target="#notify-user-modal">Notify User</button>
        </div>

    </div>
</div>
@endif

<div class="box">

    <div class="box-header with-border">
        <h2 class="box-title">{{(isset($reservation))?'Edit':'Add'}} Reservation</h2>
    </div>
    <div class="box-body">

        <form action="{{url('/admin/reservation/'.((isset($reservation))?$reservation->id:0))}}" method="post" autocomplete="off">
            <p class="text-right"><button class="btn btn-primary">Save Changes</button></p>
            <div class="row">
                <div class="col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>From</label>
                        <div class="input-group date" id="starts_at">
                            <input class="form-control date" name="starts_at" type="text" placeholder="{{date('m/d/Y')}}" value="{{old('starts_at')?old('starts_at'):((isset($reservation))?date('m/d/Y',strtotime($reservation->starts_at)):'')}}">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>To</label>
                        <div class="input-group date" id="ends_at">
                            <input class="form-control date" name="ends_at" type="text" placeholder="{{date('m/d/Y',strtotime('+3 days'))}}" value="{{old('ends_at')?old('ends_at'):((isset($reservation))?date('m/d/Y',strtotime($reservation->ends_at)):'')}}">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="alert alert-warning reservation-check-error" role="alert" style="display: none">
                Please select a starting date to see what sites are available.
            </div>
            <div class="row">
                <div class="col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>What</label>
                        <select name="what" class="form-control select-what">
                            <option {{(isset($reservation) && $reservation->reservationable_type == 'CampSite')?'selected':''}} value="CampSite">Camping</option>
                            <option {{(isset($reservation) && $reservation->reservationable_type == 'CabinSite')?'selected':''}} value="CabinSite">Cabin</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 type-col" style="{{(isset($reservation) && $reservation->reservationable_type == 'CabinSite')?'display:none':''}}">
                    <div class="form-group">
                        <label>Type</label>
                        <select name="type" class="form-control select-type">
                            <option value="rustic" {{isset($reservation) && $reservation->reservationable->type == 'rustic'?'selected':''}}>Rustic</option>
                            <option value="electric" {{isset($reservation) && $reservation->reservationable->type == 'electric'?'selected':''}}>Electric</option>
                            <option value="electric-water" {{isset($reservation) && $reservation->reservationable->type == 'electric-water'?'selected':''}}>Electric &amp; Water</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>Site</label>
                        <select name="site_id" class="form-control" id="site-id" {{count($available_spots) == 0?'disabled':''}}>
                            @foreach ($available_spots as $site)
                                <option value="{{$site->site_id}}" {{(isset($reservation) && $reservation->site_id == $site->site_id)?'selected':''}}>{{$site->site_id}}</option>
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
                            <option value="1" {{(isset($reservation) && $reservation->adult_count == 1)?'selected':''}}>1</option>
                            <option value="2" {{(isset($reservation) && $reservation->adult_count == 2)?'selected':''}}>2</option>
                            <option value="3" {{(isset($reservation) && $reservation->adult_count == 3)?'selected':''}}>3</option>
                            <option value="4" {{(isset($reservation) && $reservation->adult_count == 4)?'selected':''}}>4</option>
                            <option value="5" {{(isset($reservation) && $reservation->adult_count == 5)?'selected':''}}>5</option>
                            <option value="6" {{(isset($reservation) && $reservation->adult_count == 6)?'selected':''}}>6</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Children <small>(Ages 6-15)</small></label>
                        <select name="children_count" class="form-control">
                            <option value="0" {{(isset($reservation) && $reservation->children_count == 0)?'selected':''}}>0</option>
                            <option value="1" {{(isset($reservation) && $reservation->children_count == 1)?'selected':''}}>1</option>
                            <option value="2" {{(isset($reservation) && $reservation->children_count == 2)?'selected':''}}>2</option>
                            <option value="3" {{(isset($reservation) && $reservation->children_count == 3)?'selected':''}}>3</option>
                            <option value="4" {{(isset($reservation) && $reservation->children_count == 4)?'selected':''}}>4</option>
                            <option value="5" {{(isset($reservation) && $reservation->children_count == 5)?'selected':''}}>5</option>
                            <option value="6" {{(isset($reservation) && $reservation->children_count == 6)?'selected':''}}>6</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="control-group form-group {{(count($errors) > 0 && $errors->first('name'))?'has-error':''}}">
                        <label>Name</label>
                        <input type="text" name="name" value="{{old('name')?old('name'):((isset($reservation))?$reservation->contact_name:'')}}" size="40" class="form-control" aria-required="true" aria-invalid="false" placeholder="Name">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="control-group form-group {{(count($errors) > 0 && $errors->first('email'))?'has-error':''}}">
                        <label>Email Address</label>
                        <input type="email" name="email" value="{{old('email')?old('email'):((isset($reservation))?$reservation->contact_email:'')}}" size="40" class="form-control" aria-required="true" aria-invalid="false" placeholder="Email">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="control-group form-group {{(count($errors) > 0 && $errors->first('phone'))?'has-error':''}}">
                        <label>Phone Number</label>
                        <input type="tel" name="phone" value="{{old('phone')?old('phone'):((isset($reservation))?$reservation->contact_phone:'')}}" size="40" class="form-control" aria-required="true" aria-invalid="false" placeholder="Phone Number">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="control-group form-group">
                        <label>Best Time to Call</label>
                        <input type="text" name="best_time" value="{{old('best_time')?old('best_time'):((isset($reservation))?$reservation->best_time:'')}}" size="40" class="form-control" aria-required="true" aria-invalid="false" placeholder="ex: 5:00pm">
                    </div>
                </div>
            </div>
            <div class="control-group form-group {{(count($errors) > 0 && $errors->first('comment'))?'has-error':''}}">
                <label>User Comments</label>
                <textarea name="comment" cols="40" rows="3" class="form-control" aria-required="true" aria-invalid="false">{{old('comment')?old('comment'):((isset($reservation))?$reservation->comment:'')}}</textarea>
            </div>

            <hr>

            <div class="control-group form-group {{(count($errors) > 0 && $errors->first('admin_comment'))?'has-error':''}}">
                <label>Admin Comments</label>
                <textarea name="admin_comment" cols="40" rows="3" class="form-control" aria-required="true" aria-invalid="false">{{old('admin_comment')?old('admin_comment'):((isset($reservation))?$reservation->admin_comment:'')}}</textarea>
            </div>

            {!! csrf_field() !!}

        </form>

    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="approve-reject-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Approve / Reject</h4>
            </div>
            <div class="modal-body">
                <p>Do you want to approve or reject this reservation?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-lg btn-success btn-approve">Approve</button>
                <button type="button" class="btn btn-danger btn-reject">Reject</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="notify-user-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Notify User</h4>
            </div>
            <div class="modal-body">
                <p>Do you want to notify the user about the reservation?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-lg btn-success btn-notify">Notify</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@if(isset($reservation))
<div class="modal fade" tabindex="-1" role="dialog" id="check-in-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Check In Guest</h4>
            </div>
            <div class="modal-body">
                @if(!$reservation->is_paid)
                    <div class="alert alert-warning text-center" role="alert">
                        This guest has not fully paid.<br>
                        They owe <strong>${{$reservation->price - $reservation->down_payment}}</strong>.<br>
                        Check in the guest after they have paid in full.
                    </div>
                @endif
                <a href="{{url('/admin/check-in/'.$reservation->id)}}" class="btn btn-lg btn-primary btn-block">Check In</a>
            </div>
        </div>
    </div>
</div>
@endif

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

        $('.btn-approve').on('click', function(event)
        {
            var reservationObject =  new Object;
            reservationObject.reservation_id = {{(isset($reservation))?$reservation->id:0}}
            $.ajax({
                url: '{{url("/api/approve-reservation")}}',
                type: 'GET',
                data: reservationObject,
                success: function(data) {
                    location.reload();
                }
            });
        });

        $('.btn-reject').on('click', function(event)
        {
            var reservationObject =  new Object;
            reservationObject.reservation_id = {{(isset($reservation))?$reservation->id:0}}
            $.ajax({
                url: '{{url("/api/reject-reservation")}}',
                type: 'GET',
                data: reservationObject,
                success: function(data) {
                    location.reload();
                }
            });
        });

        $('.btn-notify').on('click', function(event)
        {
            var reservationObject =  new Object;
            reservationObject.reservation_id = {{(isset($reservation))?$reservation->id:0}}
            $.ajax({
                url: '{{url("/api/notify-reservation")}}',
                type: 'GET',
                data: reservationObject,
                success: function(data) {
                    //location.reload();
                    $('#notify-user-modal').modal('hide');
                    $('.alert-users-notified').show();
                }
            });
        });

        function checkAvailability()
        {
            $('#site-id').prop('disabled', true);
            var availabilityObject =  new Object;
            availabilityObject.starts_at = $("#starts_at input").val();
            availabilityObject.ends_at = $("#ends_at input").val();
            availabilityObject.what = $('.select-what').val();
            availabilityObject.type = $('.select-type').val();
            availabilityObject.reservation_id = {{(isset($reservation))?$reservation->id:0}}
            $.ajax({
                url: '{{url("/api/reservation-availability")}}',
                type: 'GET',
                data: availabilityObject,
                success: function(data) {
                    $('.reservation-check-error').hide();
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
                },
                error: function(data) {
                    $('.reservation-check-error').show();
                }
            });
        }
    });
</script>
@stop
