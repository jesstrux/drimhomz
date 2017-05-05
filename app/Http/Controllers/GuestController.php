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
//        $random_ads = DB::table('advertisements')->orderBy('created_at', 'asc')->limit(2)->get();
        $todayString = Carbon::today();
        $today = $todayString->toFormattedDateString();
        $houses_list = House::with('project')->orderBy('created_at', 'desc');
        $houses_json = $houses_list->get();
        $houses = $houses_list->paginate(15);

        return view('home', compact('houses', 'houses_json', 'random_ads', 'today'));
//        return view('houses-view', compact('houses'));
    }
}
