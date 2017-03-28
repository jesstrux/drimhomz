<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\House;
use App\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
//        $random_ads = DB::table('advertisements')->orderBy('created_at', 'desc')->limit(2)->get();
        $todayString = Carbon::today();
        $today = $todayString->toFormattedDateString();
        return view('home', compact('random_ads', 'today'));
    }
}
