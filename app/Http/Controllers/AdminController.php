<?php

namespace riflerivercampground\Http\Controllers;

use Illuminate\Http\Request;

use riflerivercampground\Http\Requests;
use riflerivercampground\Http\Controllers\Controller;

use Validator;

use riflerivercampground\CabinSite;
use riflerivercampground\CampSite;
use riflerivercampground\Holiday;
use riflerivercampground\Reservation;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getIndex()
    {
        $view = view('admin.index');
        $view->active_page = 'home';
        return $view;
    }

    public function getChangePassword()
    {
        $view = view('admin.change-password');
        $view->active_page = 'change-password';
        return $view;
    }

    public function postChangePassword(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|confirmed',
        ]);

        $credentials = [
            'email' => \Auth::user()->email,
            'password' => $request->get('current_password'),
        ];

        if(\Auth::validate($credentials)) {
            $user = \Auth::user();
            $user->password = bcrypt($request->get('password'));
            $user->save();
            return redirect('/admin')->with('message', 'Password changed successfully.');
        } else {
            return redirect()->back()->withErrors('Incorrect old password.');
        }
    }

    public function getPasswordReset()
    {
        $view = view('emails.password');
        $view->token = '1234';
        return $view;
    }
    
    public function getCamping()
    {
        $campsites = CampSite::orderBy('site_id', 'asc')->get();

        $view = view('admin.camping');
        $view->active_page = 'camping';
        $view->campsites = $campsites;
        return $view;
    }

    public function postCamping(Request $request)
    {

        $data = $request->all();
        $validator = Validator::make($data,
            [
                //'site_id' => 'required|unique:camp_sites',
                'adult_price' => 'required',
                'child_price' => 'required',
            ],
            [
                'site_id.required' => 'Please enter a site number.',
                'site_id.unique' => 'This site number has already been used.',
                'adult_price.required' => 'Please enter a price for adults.',
                'child_price.required' => 'Please enter a price for children.',
            ]
        );

        $validator->sometimes(['site_id'], 'required|unique:camp_sites', function($data) {
            return !$data->get('campsite_id');
        });

        if ($validator->fails()) {
            return redirect('/admin/camping')
                        ->withErrors($validator)
                        ->withInput();
        }

        if ($request->get('campsite_id'))
        {
            $campsite = CampSite::where('site_id',$request->get('campsite_id'))->first();
            $success_message = 'Campsite #'.$request->get('site_id').' was successfully updated.';
        } else {
            $campsite = new CampSite;
            $success_message = 'Campsite #'.$request->get('site_id').' was successfully added.';
        }
        $campsite->site_id = strtoupper($request->get('site_id'));
        $campsite->type = $request->get('type');
        $campsite->adult_price = $request->get('adult_price');
        $campsite->child_price = $request->get('child_price');
        $campsite->save();

        return redirect('/admin/camping')->with('success',$success_message);
    }

    public function getCabins()
    {
        $cabins = CabinSite::orderBy('site_id', 'asc')->get();

        $view = view('admin.cabins');
        $view->active_page = 'cabins';
        $view->cabins = $cabins;
        return $view;
    }

    public function postCabins(Request $request)
    {

        $data = $request->all();
        $validator = Validator::make($data,
            [
                //'site_id' => 'required|unique:cabin_sites',
                'price' => 'required',
                'additional_adult_price' => 'required',
                'additional_child_price' => 'required',
                'max_capacity' => 'required',
            ],
            [
                'site_id.required' => 'Please enter a site number.',
                'site_id.unique' => 'This site number has already been used.',
                'price.required' => 'Please enter a price.',
                'additional_adult_price.required' => 'Please enter a price for additional adults.',
                'additional_child_price.required' => 'Please enter a price for additional children.',
                'max_capacity.required' => 'Please enter a max capacity.',
            ]
        );

        $validator->sometimes(['site_id'], 'required|unique:camp_sites', function($data) {
            return !$data->get('campsite_id');
        });

        if ($validator->fails()) {
            return redirect('/admin/cabins')
                        ->withErrors($validator)
                        ->withInput();
        }

        if ($request->get('cabin_id'))
        {
            $cabinsite = CabinSite::find($request->get('cabin_id'));
            $success_message = 'Cabin #'.$request->get('site_id').' was successfully updated.';
        } else {
            $cabinsite = new CabinSite;
            $success_message = 'Cabin #'.$request->get('site_id').' was successfully added.';
        }
        $cabinsite->site_id = strtoupper($request->get('site_id'));
        $cabinsite->price = $request->get('price');
        $cabinsite->additional_adult_price = $request->get('additional_adult_price');
        $cabinsite->additional_child_price = $request->get('additional_child_price');
        $cabinsite->max_capacity = $request->get('max_capacity');
        $cabinsite->save();

        return redirect('/admin/cabins')->with('success',$success_message);
    }

    public function getHolidays()
    {
        $holidays = Holiday::where('ends_at','>=',date("Y-m-d H:i:s"))->orderBy('starts_at', 'asc')->get();

        $view = view('admin.holidays');
        $view->active_page = 'holidays';
        $view->holidays = $holidays;
        return $view;
    }

    public function postHolidays(Request $request)
    {

        $validator = $this->validate(
            $request,
            [
                'holiday_title' => 'required',
                'starts_at' => 'required',
                'ends_at' => 'required'
            ],
            [
                'holiday_title.required' => 'Please enter a title for this holiday.',
                'starts_at.required' => 'Please enter when this holiday will start.',
                'ends_at.required' => 'Please enter when this holiday will end.',
            ]
        );

        if ($request->get('holiday_id'))
        {
            $holiday = Holiday::find($request->get('holiday_id'));
            $success_message = 'The holiday, '.$request->get('holiday_title').', was successfully updated.';
        } else {
            $holiday = new Holiday;
            $success_message = 'The holiday, '.$request->get('holiday_title').', was successfully added.';
        }
        $holiday->title = $request->get('holiday_title');
        $holiday->starts_at = date('Y-m-d H:i:s', strtotime($request->get('starts_at')));
        $holiday->ends_at = date('Y-m-d H:i:s', strtotime($request->get('ends_at')));
        $holiday->save();

        return redirect('/admin/holidays')->with('success',$success_message);
    }

    public function getReservations(Request $request, $edit_add = null, $reservation_id = null)
    {
        if ($edit_add == 'add') {
            return $this->addReservation();
        } elseif ($edit_add == 'edit' && $reservation_id) {
            return $this->editReservation($reservation_id);
        }
        $reservations = Reservation::active()->where('starts_at','>=',date('Y-m-d H:i:s'))->get();
        if($request->get('view') == 'today')
        {
            $reservations = Reservation::active()->where('starts_at','>=',date('Y-m-d H:i:s'))->where('starts_at','<=',date('Y-m-d H:i:s',strtotime('+1 day')))->get();
        }
        if($request->get('view') == 'thisweek')
        {
            $reservations = Reservation::active()->where('starts_at','>=',date('Y-m-d H:i:s'))->where('starts_at','<=',date('Y-m-d H:i:s',strtotime('Next Sunday')))->get();
        }
        if($request->get('view') == 'nextweek')
        {
            $reservations = Reservation::active()->where('starts_at','>=',date('Y-m-d H:i:s',strtotime('Next Sunday')))->where('starts_at','<=',date('Y-m-d H:i:s',strtotime('Next Sunday', strtotime('Next Sunday'))))->get();
        }
        if($request->get('view') == 'nextmonth')
        {
            $reservations = Reservation::active()->where('starts_at','>=',date('Y-m-d H:i:s',strtotime('Next Month')))->where('starts_at','<=',date('Y-m-d H:i:s',strtotime('+2 Months')))->get();
        }
        if($request->get('view') == 'disabled')
        {
            $reservations = Reservation::active()->unapproved()->get();
        }
        if($request->get('view') == 'disabled')
        {
            $reservations = Reservation::inactive()->get();
        }
        if($request->get('view') == 'old')
        {
            $reservations = Reservation::active()->where('starts_at','<=',date('Y-m-d H:i:s'))->get();
        }
        if($request->get('view') == 'all')
        {
            $reservations = Reservation::get();
        }
        foreach ($reservations as $reservation) {
            if ($reservation->reservationable_type == 'CampSite') {
                $reservationable = CampSite::find($reservation->reservationable_id);
            } else {
                $reservationable = CabinSite::find($reservation->reservationable_id);
            }
            $reservation->reservationable = $reservationable;
        }
        $upcomming_reservations_count = Reservation::active()->where('starts_at','>=',date('Y-m-d H:i:s'))->count();
        $today_reservations_count = Reservation::active()->where('starts_at','>=',date('Y-m-d H:i:s'))->where('starts_at','<=',date('Y-m-d H:i:s',strtotime('+1 day')))->count();
        $thisweek_reservations_count = Reservation::active()->where('starts_at','>=',date('Y-m-d H:i:s'))->where('starts_at','<=',date('Y-m-d H:i:s',strtotime('Next Sunday')))->count();
        $nextweek_reservations_count = Reservation::active()->where('starts_at','>=',date('Y-m-d H:i:s',strtotime('Next Sunday')))->where('starts_at','<=',date('Y-m-d H:i:s',strtotime('Next Sunday', strtotime('Next Sunday'))))->count();
        $nextmonth_reservations_count =  Reservation::active()->where('starts_at','>=',date('Y-m-d H:i:s',strtotime('Next Month')))->where('starts_at','<=',date('Y-m-d H:i:s',strtotime('+2 Months')))->count();
        $unapproved_reservations_count = Reservation::active()->unapproved()->count();
        $rejected_reservations_count = Reservation::inactive()->count();
        $old_reservations_count = Reservation::active()->where('starts_at','<=',date('Y-m-d H:i:s'))->count();
        $all_reservations_count = Reservation::count();

        $view = view('admin.reservations');
        $view->active_page = 'reservations';
        $view->reservations = $reservations;
        $view->upcomming_reservations_count = $upcomming_reservations_count;
        $view->thisweek_reservations_count = $thisweek_reservations_count;
        $view->today_reservations_count = $today_reservations_count;
        $view->nextweek_reservations_count = $nextweek_reservations_count;
        $view->nextmonth_reservations_count = $nextmonth_reservations_count;
        $view->unapproved_reservations_count = $unapproved_reservations_count;
        $view->rejected_reservations_count = $rejected_reservations_count;
        $view->old_reservations_count = $old_reservations_count;
        $view->all_reservations_count = $all_reservations_count;
        return $view;
    }

    protected function addReservation()
    {
        $view = view('admin.edit-add-reservations');
        $view->active_page = 'add-reservation';
        $view->available_spots = CampSite::get();
        return $view;
    }

    protected function editReservation($reservation_id)
    {
        $reservation = Reservation::find($reservation_id);
        if (!$reservation)
            return redirect('/reservations');
        
        if ($reservation->reservationable_type == 'CampSite') {
            $available_spots = CampSite::get();
        } else {
            $available_spots = CabinSite::get();
        }

        if ($reservation->reservationable_type == 'CampSite') {
            $reservationable = CampSite::find($reservation->reservationable_id);
        } else {
            $reservationable = CabinSite::find($reservation->reservationable_id);
        }
        $reservation->reservationable = $reservationable;

        $view = view('admin.edit-add-reservations');
        $view->active_page = 'reservations';
        $view->reservation = $reservation;
        $view->available_spots = $available_spots;
        return $view;
    }

    public function postReservation(Request $request, $reservation_id)
    {
        $reservation = Reservation::find($reservation_id);
        if (!$reservation) {
            $reservation = new Reservation;
        }
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

        //$reservation = new Reservation;
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

        return redirect('/admin/reservations')->with('status', 'The reservation has been saved. The confirmation number is '.$reservation->id.'.');
    }
}
