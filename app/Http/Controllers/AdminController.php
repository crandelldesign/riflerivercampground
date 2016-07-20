<?php

namespace riflerivercampground\Http\Controllers;

use Illuminate\Http\Request;

use riflerivercampground\Http\Requests;
use riflerivercampground\Http\Controllers\Controller;

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

        $validator = $this->validate(
            $request,
            [
                'site_id' => 'required|unique:camp_sites',
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

        if ($request->get('campsite_id'))
        {
            $campsite = CampSite::find($request->get('campsite_id'));
            $success_message = 'Campsite #'.$request->get('site_id').' was successfully updated.';
        } else {
            $campsite = new CampSite;
            $success_message = 'Campsite #'.$request->get('site_id').' was successfully added.';
        }
        $campsite->site_id = $request->get('site_id');
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

        $validator = $this->validate(
            $request,
            [
                'site_id' => 'required|unique:cabin_sites',
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

        if ($request->get('campsite_id'))
        {
            $cabinsite = CabinSite::find($request->get('cabin_id'));
            $success_message = 'Cabin #'.$request->get('site_id').' was successfully updated.';
        } else {
            $cabinsite = new CabinSite;
            $success_message = 'Cabin #'.$request->get('site_id').' was successfully added.';
        }
        $cabinsite->site_id = $request->get('site_id');
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

        $view = view('admin.edit-add-reservations');
        $view->active_page = 'reservations';
        $view->reservation = $reservation;
        $view->available_spots = $available_spots;
        return $view;
    }
}
