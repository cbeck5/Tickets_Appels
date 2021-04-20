<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use DateTime;

class HomeController extends Controller
{
    /**
     * Show the index on home.
     */
    public function index()
    {   

        return view('home');

    }
}