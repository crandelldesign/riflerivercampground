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

class HomeController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Home Controller
    |--------------------------------------------------------------------------
    */

    public function getIndex()
    {
        $view = view('home.index');
        $view->title = "Welcome to Rifle River Campground";
        $view->description = "Rifle River Campground & Canoe Livery, LLC is located in Sterling, MI along the beautiful Rifle River. We offer camping both modern and rustic camping with over 25 campsites directly on the river. Whether you prefer to enjoy to serenity of the river in one of our canoes, tubes or kayaks or simply want...";
        $view->active_page = 'home';
        return $view;
    }

    public function postSubheadReservation(Request $request)
    {
        $starts_at = date('Y-m-d', strtotime($request->get('starts_at')?$request->get('starts_at'):'today'));
        $ends_at = date('Y-m-d', strtotime($request->get('ends_at')?$request->get('ends_at'):'+2 Days'));
        $what = $request->get('what');

        return redirect('/reservations?starts_at='.$starts_at.'&ends_at='.$ends_at.'&what='.$what);
    }

    public function getReservations(Request $request)
    {
        $view = view('home.reservations');
        $view->title = "Reservations";
        $view->description = "Reserve a campsite or a cabin for your next vacation at Rifle River Campground in Sterling, MI.";
        $view->active_page = 'reservations';

        if ($request->get('starts_at')) {
            $starts_at = strtotime($request->get('starts_at'));
            $ends_at = strtotime($request->get('ends_at'));
            $what = $request->get('what');

            $existing_reseravtion_ids = Reservation::where('starts_at','>=',date("Y-m-d H:i:s", $starts_at))
                ->where('starts_at','<',date("Y-m-d H:i:s", $ends_at))->where('reservationable_type',$what)->lists('reservationable_id')->toArray();
            if ($what == 'CampSite') {
                $available_spots = CampSite::whereNotIn('id', $existing_reseravtion_ids)->get();
            } else {
                $available_spots = CabinSite::whereNotIn('id', $existing_reseravtion_ids)->get();
            }

            $view->starts_at = $starts_at;
            $view->ends_at = $ends_at;
            $view->what = $what;
            $view->available_spots = $available_spots;
        } else {
            $view->available_spots = CampSite::get();
        }

        return $view;
    }

    public function postReservations(Request $request)
    {
        // Needs Validation

        $starts_at = strtotime($request->get('starts_at'));
        $ends_at = strtotime($request->get('ends_at'));
        $days = intval(abs($ends_at - $starts_at)/86400);
        $what = $request->get('what');
        $existing_reseravtion_ids = Reservation::active()->where('starts_at','>=',date("Y-m-d H:i:s", $starts_at))
            ->where('starts_at','<',date("Y-m-d H:i:s", $ends_at))->where('reservationable_type',$what)->lists('reservationable_id')->toArray();
        if ($what == 'CampSite') {
            $available_spots = CampSite::whereNotIn('id', $existing_reseravtion_ids)->get();
        } else {
            $available_spots = CabinSite::whereNotIn('id', $existing_reseravtion_ids)->get();
        }

        if (empty($available_spots)) {
            return back()->with('reservation_error', 'Your requested spot is unavilable')->withInput();
        }

        if ($what == 'CampSite') {
            $reservationable = CampSite::where('site_id',$request->get('site_id'))->first();
            $reservationable->reservationable_type = 'CampSite';

            // Price Logic
            $adult_price = $reservationable->adult_price;
            $child_price = $reservationable->child_price;
            $price = ($adult_price * $request->get('adult_count')) + ($child_price * $request->get('children_count'));
        } else {
            $reservationable = CabinSite::where('site_id',$request->get('site_id'))->first();
            $reservationable->reservationable_type = 'CabinSite';

            // Price Logic
            $price = $reservationable->price;
            $total_count = $request->get('adult_count') + $request->get('children_count');
            if($total_count > 4) {
                $adult_price = $reservationable->additional_adult_price;
                $child_price = $reservationable->additional_child_price;
                $additional_adult_count = $request->get('adult_count') - 4;
                $additional_children_count = $request->get('children_count') - abs(min($additional_adult_count,0));
                $price = $price + max($adult_price * $additional_adult_count,0) + max($child_price * $additional_children_count,0);
            }
        }
        $price = $price * $days;

        $reservation = new Reservation;
        $reservation->starts_at = date('Y-m-d H:i:s', strtotime($request->get('starts_at')));
        $reservation->ends_at = date('Y-m-d H:i:s', strtotime($request->get('ends_at')));
        $reservation->site_id = $request->get('site_id');
        $reservation->reservationable_id = $reservationable->id;
        $reservation->reservationable_type = $reservationable->reservationable_type;
        $reservation->adult_count = $request->get('adult_count');
        $reservation->children_count = $request->get('children_count');
        $reservation->price = $price;
        $reservation->contact_name = $request->get('name');
        $reservation->contact_email = $request->get('email');
        $reservation->contact_phone = $request->get('phone');
        $reservation->best_time = $request->get('best_time');
        $reservation->comment = $request->get('comment');
        $reservation->save();

        $reservation->reservationable = $reservationable;

        $data = array(
            'reservation' => $reservation,
        );

        Mail::send('emails.reservation-admin', $data, function($message) use ($request)
        {
            $message->to('reservations@riflerivercampground.com', 'Rifle River Campground Reservations');
            $message->replyTo($request->get('email'), $request->get('name'));
            $message->subject('A Reservation has been made on the Rifle River Campground Website');
        });

        Mail::send('emails.reservation', $data, function($message) use ($request)
        {
            $message->to($request->get('email'), $request->get('name'));
            $message->replyTo('reservations@riflerivercampground.com', 'Rifle River Campground Reservations');
            $message->subject('Thank You for Your Reservation');
        });

        return redirect('/reservations')->with('status', 'Thank you for your reservation. Your confirmation number is '.$reservation->id.'. We will get back to you as soon as possible.');
    }

    public function getCamping()
    {
        $view = view('home.camping');
        $view->title = "Camping";
        $view->description = "Our campground is RV and tent friendly and has many types of sites to meet your camping needs. All of our sites are grassy for your comfort. Over 25 of our sites are directly on the water’s edge. All of our campsites have a fire pit and picnic table. Our sites vary in size...";
        $view->active_page = 'camping';
        return $view;
    }

    public function getCabins()
    {
        $view = view('home.cabins');
        $view->title = "Cabins";
        $view->description = "Open the windows at night and fall asleep to the sound of the babbling river, while resting comfortably on a real bed. Camping cabins are now available for those who want to experience the beauty of the outdoors while enjoying some of the creature comforts of home. Our Amish-built cabins feature a cozy porch with...";
        $view->active_page = 'cabins';
        return $view;
    }

    public function getRiverTrips($sub = null)
    {
        if ($sub == 'canoeing') {
            $view = view('home.canoeing');
            $view->title = "Canoeing";
            $view->description = "Drift down the Rifle in one of our aluminum canoes.";
            $view->active_page = 'river-trips';
            return $view;
        } elseif ($sub == 'kayaking') {
            $view = view('home.kayaking');
            $view->title = "Kayaking";
            $view->description = "Looking to be closer to the water but not in it? Try kayaking! Kayaks are easier to paddle for those going on their first water trip. Kayaks are easier to maneuver. We offer kayaks for one or two riders. Single rider kayaks are available in two styles: sit on top or sit inside.";
            $view->active_page = 'river-trips';
            return $view;
        } elseif ($sub == 'tubing') {
            $view = view('home.tubing');
            $view->title = "Tubing";
            $view->description = "Lay back and relax as you drift your way down the river on one of our tubes. We offer several styles of tubes to suit you. Our Deluxe tubes offer the most comfort while floating, as they are a larger tube with a back rest.";
            $view->active_page = 'river-trips';
            return $view;
        } elseif ($sub == 'specials') {
            $view = view('home.specials');
            $view->title = "Specials";
            $view->description = "River trip specials";
            $view->active_page = 'river-trips';
            return $view;
        } else {
            $view = view('home.river-trips');
            $view->title = "River Trips";
            $view->description = "There are many fun ways to make it down the beautiful Rifle River. Check them out to see more. Canoeing, Kayaking, and Tubing";
            $view->active_page = 'river-trips';
            return $view;
        }
    }

    public function getParkMap()
    {
        $view = view('home.park-map');
        $view->title = "Park Map";
        $view->description = "Map of the park";
        $view->active_page = 'park-map';
        return $view;
    }

    public function getPhotos()
    {
        $view = view('home.photos');
        $view->title = "Photos";
        $view->description = "Rifle River Campground is a beautiful place to visit. Check out the images to see for yourself.";
        $view->active_page = 'photos';
        return $view;
    }

    public function getContact()
    {
        $view = view('home.contact');
        $view->title = "Contact";
        $view->description = "Rifle River Campgrouns is located at 5825 Town Line Rd, Sterling, MI";
        $view->active_page = 'contact';
        return $view;
    }

    public function postContact(Request $request)
    {
        $validator = $this->validate(
            $request,
            [
                'name' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'g-recaptcha-response' => 'required',
                'message' => 'required'
            ],
            [
                'name.required' => 'Please enter your name.',
                'email.required' => 'Please enter your email address.',
                'phone.required' => 'Please enter your phone number.',
                'g-recaptcha-response.required' => 'Please check the reCAPTCHA box.',
                'message.required' => 'Please enter a message.'
            ]
        );

        $data = array(
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'best_time' => $request->get('best_time'),
            'message_text' => $request->get('message'),
        );

        Mail::send('emails.contact', $data, function($message) use ($request)
        {
            $message->to('reservations@riflerivercampground.com', 'Rifle River Campground Reservations');
            $message->from('reservations@riflerivercampground.com', 'Rifle River Campground Reservations');
            $message->replyTo($request->get('email'), $request->get('name'));
            $message->subject('You\'ve Been Contacted by the Rifle River Campground Website.');
        });

        Analytics::trackEvent('Email', 'sent', 'Email Sent', 1);

        return redirect('/contact')->with('status', 'Thank you for contacting us, we will get back to you as soon as possible.');
    }
}
