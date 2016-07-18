<?php

namespace riflerivercampground\Http\Controllers;

use riflerivercampground\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;
use Analytics;

use riflerivercampground\CabinSite;
use riflerivercampground\CampSite;
use riflerivercampground\Holiday;
use riflerivercampground\Reservation;

class ApiController extends Controller
{
    public function getReservationAvailability(Request $request)
    {
        if (!$request->get('starts_at'))
            abort(400);

        $starts_at = strtotime($request->get('starts_at'));
        $ends_at = strtotime($request->get('ends_at'));
        $what = $request->get('what');
        $type = $request->get('type');

        $existing_reservation_ids = Reservation::where('starts_at','>=',date("Y-m-d H:i:s", $starts_at))
            ->where('starts_at','<',date("Y-m-d H:i:s", $ends_at))->where('reservationable_type',$what);
        if ($request->get('reservation_id') > 0) {
            $existing_reservation_ids = $existing_reservation_ids->where('id','!=',$request->get('reservation_id'));
        }
        $existing_reservation_ids = $existing_reservation_ids->lists('reservationable_id')->toArray();
        if ($what == 'CampSite') {
            $available_spots = CampSite::whereNotIn('id', $existing_reservation_ids)->where('type',$type)->get();
        } else {
            $available_spots = CabinSite::whereNotIn('id', $existing_reservation_ids)->get();
        }

        return json_encode($available_spots);
    }
}