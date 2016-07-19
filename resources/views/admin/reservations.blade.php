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
        <ul class="list-inline">
            <li><a href="?view=upcoming">Upcoming ({{$upcomming_reservations_count}})</a></li>
            <li><a href="#">This Week</a></li>
            <li><a href="#">Next Week</a></li>
            <li><a href="#">Next Month</a></li>
            <li><a href="#">Pending</a></li>
            <li><a href="?view=disabled">Rejected ({{$rejected_reservations_count}})</a></li>
            <li><a href="#">All</a></li>
            <li><a href="#">Old</a></li>
        </ul>
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