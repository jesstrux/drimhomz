<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\Page;
use App\User;
use App\House;
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
        $randomHouses = House::all();
        // $len = count($db_values) - 1;
        // $randomHouses = array();
        $todayString = Carbon::today();
        $today = $todayString->toFormattedDateString();

        // for ($i=0; $i < 10; $i++) {
        //     $rand = rand ( 0 , $len );
        //     $value = $db_values[$rand];
        //     $randomHouses []= $value;
        // }

        return view('home', compact('randomHouses', 'today'));
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
            
            $db_values = House::all();
            $len = count($db_values) - 1;
            $randomHouses = array();
            $todayString = Carbon::today();
            $today = $todayString->toFormattedDateString();

            for ($i=0; $i < 10; $i++) {
                $rand = rand ( 0 , $len );
                $value = $db_values[$rand];
                $randomHouses []= $value;
            }

            return view('home.dashboard', compact('pages', 'users', 'randomHouses', 'today'));
        }else{

            $db_values = House::all();
            $len = count($db_values) - 1;
            $randomHouses = array();
            $todayString = Carbon::today();
            $today = $todayString->toFormattedDateString();

            for ($i=0; $i < 10; $i++) {
                $rand = rand ( 0 , $len );
                $value = $db_values[$rand];
                $randomHouses []= $value;
            }

            return view('home', compact('randomHouses', 'today'));
        }
    }
}
