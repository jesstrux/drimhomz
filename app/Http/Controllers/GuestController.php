<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\House;
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
        // $db_values = House::all();
        $randomHouses = House::all();
        $todayString = Carbon::today();
        $today = $todayString->toFormattedDateString();

        // for ($i=0; $i < 10; $i++) {
        //     $rand = rand ( 0 , $len );
        //     $value = $db_values[$rand];
        //     $randomHouses []= $value;
        // }

        return view('home', compact('randomHouses', 'today'));
    }
}
