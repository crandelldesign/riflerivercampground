@extends('layouts.admin')
@section('content-header')
    <h1>Reservations</h1>
@stop
@section('content')

<div class="box">
    <div class="box-header with-border">
        <h2 class="box-title">Reservations</h2>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table class="table table-striped reservations">
            <thead>
                <tr>
                    <td><label>Search ID</label><br><input type="text" id="search-id" placeholder="Search Reservation ID" class="form-control"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <th>Confirmation ID</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservations as $reservation)
                    <tr data-event_id="{{$reservation->id}}">
                        <td class="reservation-id">{{$reservation->id}}</td>
                        <td class="reservation-start">{{date("m/d/Y", strtotime($reservation->starts_at))}}</td>
                        <td class="reservation-end">{{date("m/d/Y", strtotime($reservation->ends_at))}}</td>
                        <td></td>
                        <td></td>
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
            "aaSorting": []
        });
        $('#search-id').on('keyup change', function(){
            reservation_table
                .column(0)
                .search(this.value)
                .draw();
        });
    });
</script>
@stop