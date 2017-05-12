<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\Page;
use App\User;
use App\House;
use App\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
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


        $random_ads = Advertisement::all();
//        $random_ads = DB::table('advertisements')->orderBy('created_at', 'asc')->limit(2)->get();
        $todayString = Carbon::today();
        $today = $todayString->toFormattedDateString();
        $houses = House::with('project')->orderBy('created_at', 'desc')->paginate(15);

        return view('home', compact('random_ads', 'today', 'houses'));
//        return view('houses-view', compact('houses'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
//        if(Auth::user()->role == "admin"){
            $pages = Page::all();
            $users = User::all();

            $todayString = Carbon::today();
            $today = $todayString->toFormattedDateString();

            $db_values = DB::table('advertisements')->orderBy('created_at', 'desc')->get();
            $randomAds = $db_values;
            $len = count($db_values);
//            $randomAds = array();


//            if($len > 0){
//                for ($i=0; $i < 10; $i++) {
//                    $rand = rand ( 0 , $len - 1 );
//                    $value = $db_values[$rand];
//                    $randomAds[]= $value;
//                }
//            }

            return view('home.dashboard', compact('pages', 'users', 'randomAds', 'today'));
//        }else{
//
//            return redirect('home/');
//        }
    }
}
