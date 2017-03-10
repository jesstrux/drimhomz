<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\House;
use App\Advertisement;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the home page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $random_ads = Advertisement::all();
        $todayString = Carbon::today();
        $today = $todayString->toFormattedDateString();
        return view('home', compact('random_ads', 'today'));
    }
}
