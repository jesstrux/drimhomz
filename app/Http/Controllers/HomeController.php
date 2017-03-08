<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\Page;
use App\User;
use App\House;
use App\Advertisement;
use Illuminate\Http\Request;

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
        // $db_values = House::all();
        $random_ads = Advertisement::all();
        // $len = count($db_values) - 1;
        // $randomHouses = array();
        $todayString = Carbon::today();
        $today = $todayString->toFormattedDateString();

        // for ($i=0; $i < 10; $i++) {
        //     $rand = rand ( 0 , $len );
        //     $value = $db_values[$rand];
        //     $randomHouses []= $value;
        // }

        return view('home', compact('random_ads', 'today'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        if(Auth::user()->role == "admin"){
            $pages = Page::all();
            $users = User::all();
            
            $db_values = Advertisement::all();
            $len = count($db_values);
            $randomAds = array();
            
            $todayString = Carbon::today();
            $today = $todayString->toFormattedDateString();

            if($len > 0){
                for ($i=0; $i < 10; $i++) {
                    $rand = rand ( 0 , $len - 1 );
                    $value = $db_values[$rand];
                    $randomAds[]= $value;
                }
            }

            return view('home.dashboard', compact('pages', 'users', 'randomAds', 'today'));
        }else{

            $db_values = Advertisement::all();
            $len = count($db_values) - 1;
            $randomAds = array();
            $todayString = Carbon::today();
            $today = $todayString->toFormattedDateString();

            for ($i=0; $i < 10; $i++) {
                $rand = rand ( 0 , $len );
                $value = $db_values[$rand];
                $randomAds []= $value;
            }

            return view('home', compact('randomAds', 'today'));
        }
    }
}
