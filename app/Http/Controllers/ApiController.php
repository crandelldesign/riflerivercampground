<?php

namespace riflerivercampground\Http\Controllers;

use riflerivercampground\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;
use Analytics;
use Auth;

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
            $available_spots = CampSite::whereNotIn('id', $existing_reservation_ids)->where('type',$type)->get()->sortBy('site_id', SORT_REGULAR, false);
        } else {
            $available_spots = CabinSite::whereNotIn('id', $existing_reservation_ids)->get()->sortBy('site_id', SORT_REGULAR, false);
        }

        return json_encode($available_spots);
    }

    public function getMinimumStay(Request $request)
    {
        $starts_at = strtotime($request->get('starts_at'));
        $holidays = Holiday::where('starts_at','<=',date("Y-m-d H:i:s", $starts_at))
            ->where('ends_at','>',date("Y-m-d H:i:s", $starts_at))->first();
        if($holidays)
            return 3;
        else
            return 2;
    }

    public function getApproveReservation(Request $request)
    {
        if (!$request->get('reservation_id'))
            abort(400);

        if (!Auth::check())
            abort(400);

        $reservation = Reservation::find($request->get('reservation_id'));
        $reservation->is_approved = 1;
        $reservation->date_approved = date('Y-m-d H:i:s');
        $reservation->is_active = 1;
        $reservation->save();

        return json_encode($reservation);
    }

    public function getRejectReservation(Request $request)
    {
        if (!$request->get('reservation_id'))
            abort(400);

        if (!Auth::check())
            abort(400);

        $reservation = Reservation::find($request->get('reservation_id'));
        $reservation->is_approved = 0;
        $reservation->date_approved = null;
        $reservation->is_active = 0;
        $reservation->save();

        return json_encode($reservation);
    }

    public function getNotifyReservation(Request $request)
    {
        if (!$request->get('reservation_id'))
            abort(400);

        if (!Auth::check())
            abort(400);

        $reservation = Reservation::find($request->get('reservation_id'));
        $data = array(
            'reservation' => $reservation,
        );
         Mail::send('emails.reservation-notify', $data, function($message) use ($reservation)
        {
            $message->to($reservation->contact_email, $reservation->contact_name);
            $message->replyTo('reservations@riflerivercampground.com', 'Rifle River Campground Reservations');
            $message->subject('Reminder of Your Reservation');
        });

        return json_encode($reservation);
    }
}
