@extends('layouts.admin')
@section('head')
<link rel="stylesheet" type="text/css" href="{{url('/css/datatables/datatables.min.css')}}" />
@stop
@section('content-header')
    <h1>Reservations</h1>
@stop
@section('content')

<div class="box">
    <div class="box-header with-border">
        <h2 class="box-title">Reservations</h2>
    </div>
    <div class="box-body">

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @include('layouts.reservation-month')

        <ul class="list-inline hidden">
            <li class="{{(!isset($view) || $view == 'upcoming')?'active':''}}"><a href="?view=upcoming">Upcoming ({{$upcomming_reservations_count}})</a></li>
            <li class="{{(isset($view) && $view == 'today')?'active':''}}"><a href="?view=today">Today ({{$today_reservations_count}})</a></li>
            <li class="{{(isset($view) && $view == 'thisweek')?'active':''}}"><a href="?view=thisweek">This Week ({{$thisweek_reservations_count}})</a></li>
            <li class="{{(isset($view) && $view == 'nextweek')?'active':''}}"><a href="?view=nextweek">Next Week ({{$nextweek_reservations_count}})</a></li>
            <li class="{{(isset($view) && $view == 'nextmonth')?'active':''}}"><a href="?view=nextmonth">Next Month ({{$nextmonth_reservations_count}})</a></li>
            <li class="{{(isset($view) && $view == 'pending')?'active':''}}"><a href="?view=pending">Pending ({{$unapproved_reservations_count}})</a></li>
            <li class="{{(isset($view) && $view == 'disabled')?'active':''}}"><a href="?view=disabled">Rejected ({{$rejected_reservations_count}})</a></li>
            <li class="{{(isset($view) && $view == 'old')?'active':''}}"><a href="?view=old">Old ({{$old_reservations_count}})</a></li>
            <li class="{{(isset($view) && $view == 'all')?'active':''}}"><a href="?view=all">All ({{$all_reservations_count}})</a></li>
            <li><a href="{{url('/admin/reservations/add')}}">Add New Reservation</a></li>
        </ul>
        <h3 class="margin-top-0 margin-bottom-0 text-center">Reservations for {{date('n/j/Y',$date)}}</h3>
        <div class="table-responsive">
            <table class="table table-striped reservations">
            <thead>
                <tr>
                    <td><label>Search ID</label><br><input type="text" id="search-id" placeholder="Search Reservation ID" class="form-control"></td>
                    <td><label>Search Name</label><br><input type="text" id="search-name" placeholder="Search Names" class="form-control"></td>
                </tr>
                <tr>
                    <th>Confirmation ID</th>
                    <th>Contact Name</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Price</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservations as $reservation)
                    <tr data-event_id="{{$reservation->id}}">
                        <td class="reservation-id">{{$reservation->id}}</td>
                        <td>{{$reservation->contact_name}}</td>
                        <td class="reservation-start">{{date("m/d/Y", strtotime($reservation->starts_at))}}</td>
                        <td class="reservation-end">{{date("m/d/Y", strtotime($reservation->ends_at))}}</td>
                        <td>${{$reservation->price}}</td>
                        <td>@if ($reservation->reservationable_type == 'CampSite')
                        @if ($reservation->reservationable->type == 'rustic')
                                Rustic Camp Site
                            @else
                                Modern Camp Site
                            @endif
                        @else
                            Cabin
                        @endif</td>
                        <td>
                            @if($reservation->is_checked_in)
                                <span class="label label-success">Checked In</span>
                            @elseif($reservation->is_approved)
                                <span class="label label-success">Checked In</span>
                            @else
                                <span class="label label-warning">Pending</span>
                            @endif
                        </td>
                        <td class="text-right"><a href="{{url('/admin/reservations/edit/'.$reservation->id)}}" class="btn btn-xs btn-primary btn-see-more">See More</button>
                       <!-- <td><button type="button" class="btn btn-xs btn-success delete-event" data-reservation="{{$reservation->id}}"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;&nbsp;Approve</button></td>
                        <td><button type="button" class="btn btn-xs btn-danger delete-event" data-reservation="{{$reservation->id}}"><i class="fa fa-trash" aria-hidden="true"></i>&nbsp;&nbsp;Disable</button></td>-->
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@stop
@section('scripts')
<script type="text/javascript" src="{{url('/js/datatables/datatables.min.js')}}"></script>
<script>
    $(document).ready(function()
    {
        var reservation_table = $('.reservations').DataTable({
            // Display 25 rows by default
            "pageLength": 25,
            // Disable initial sorting
            "aaSorting": [],
            "aoColumns": [
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                { "bSortable": false }
            ]
        });
        $('#search-id').on('keyup change', function(){
            reservation_table
                .column(0)
                .search(this.value)
                .draw();
        });
        $('#search-name').on('keyup change', function(){
            reservation_table
                .column(1)
                .search(this.value)
                .draw();
        });
    });
</script>
@stop
