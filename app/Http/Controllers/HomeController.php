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
        $view->title = "Rifle River Campground";
        $view->description = "Rifle River Campground";
        $view->active_page = 'home';
        return $view;
    }
}
