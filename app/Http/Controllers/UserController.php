<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\User;
use App\House;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
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

    public function profile(){
    	$user_id = Auth::user()->id;
    	
    	$my_houses = House::get();
    	return view('home.profile');
    }

    public function setup(){
        $user = Auth::user();
        return view('user.setup', compact('user'));
    }

    function showprofile($id){
        $authuser = Auth::user();
        $user = User::with('houses')->find($id);
        $myProfile = $authuser->id == $user->id;

        return view('user.userview', compact('user', 'myProfile'));
        // $houses = $user->houses;

        // foreach ($houses as $house) {
            // echo $house->title.",<br>";
        // }
        // return $user->houses->count();
    }

    function toggle_admin(Request $request){
        $authuser = Auth::user();
        $amiAdmin = $authuser->role == 'admin';
        $id = $request->input('id');
        $user = User::find($id);
        $isadmin = $user->role == 'admin' ? true : false;
        
        if($amiAdmin){
            if(!$isadmin)
                $user->role = 'admin';
            else
                $user->role = 'user';

            return response()->json([
                'success' => $user->save()
            ]);
        }
        else{
            return response()->json([
                'success' => false,
                'reason' => "Not admin"
            ]);
        }
        // return "Am i admin? ". $amiAdmin. ", Is user already admin? ". ($user->role == "admin");
    }

    function setupProfile(Request $request){
        $user = User::find(Auth::user()->id);
        // $user->gender = $request->gender;
        // $user->town = $request->town;
        // $user->dob = $request->dob;

        $user->fname = $request->input('fname');
        $user->lname = $request->input('lname');
        $user->phone = $request->input('phone');
        $user->gender = $request->input('gender');
        $user->town = $request->input('town');
        $time = strtotime($request->input('dob'));
        $user->dob = strftime("%Y-%m-%d %H:%M:%S", $time);
        if($user->save()){
            return "success";
        }
        else {
            return response('error!');
        }
    }

    function saveDp(Request $request){
        $user = User::find(Auth::user()->id);
        // $path = Storage::put('dps', $request->file('dp'), 'public');
        // $path = $request->file('dp')->store('uploads/dps');
        $photoName = $request->file('dp')->getClientOriginalName();
        $destination = base_path()."/public/images/uploads";
        $request->file('dp')->move($destination, $photoName);
        $user->dp = $photoName;
        $user->save();
        
        if($user->save()){
            return "success";
        }
        else {
            return response('error!');
        }
    }
}
