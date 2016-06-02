<?php

namespace riflerivercampground\Http\Controllers;

use Illuminate\Http\Request;

use riflerivercampground\Http\Requests;
use riflerivercampground\Http\Controllers\Controller;

use riflerivercampground\CalendarEvent;
use riflerivercampground\Holiday;

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

    public function getHolidays()
    {
        $holidays = Holiday::where('ends_at','<=',date("Y-m-d H:i:s"))->orderBy('starts_at', 'desc')->get();

        $view = view('admin.holidays');
        $view->active_page = 'holidays';
        $view->holidays = $holidays;
        return $view;
    }
}
