<?php

namespace riflerivercampground\Http\Controllers;

use riflerivercampground\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;

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

    public function getCamping()
    {
        $view = view('home.camping');
        $view->title = "Camping";
        $view->description = "Our campground is RV and tent friendly and has many types of sites to meet your camping needs. All of our sites are grassy for your comfort. Over 25 of our sites are directly on the water’s edge. All of our campsites have a fire pit and picnic table. Our sites vary in size...";
        $view->active_page = 'camping';
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
        print_r($request->all());
        //exit;

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
            $message->to('mrcrandell@gmail.com', 'Rifle River Campground Reservations');
            $message->from('reservations@riflerivercampground.com', 'Rifle River Campground Reservations');
            $message->replyTo($request->get('email'), $request->get('name'));
            $message->subject('You\'ve Been Contacted by the Rifle River Campground Website.');
        });

        return redirect('/contact')->with('status', 'Thank you for contacting us, we will get back to you as soon as possible.');
    }
}
