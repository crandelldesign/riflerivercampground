<?php

namespace riflerivercampground\Http\Controllers;

use riflerivercampground\Http\Controllers\Controller;

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
        $view->title = "contact";
        $view->description = "Our campground is RV and tent friendly and has many types of sites to meet your camping needs. All of our sites are grassy for your comfort. Over 25 of our sites are directly on the water’s edge. All of our campsites have a fire pit and picnic table. Our sites vary in size...";
        $view->active_page = 'contact';
        return $view;
    }
}
