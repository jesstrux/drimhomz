<?php

namespace App\Http\Controllers;

use App\Message;
use Auth;
use Carbon\Carbon;

use App\User;
use App\Office;
use App\House;
use App\Follows;
use App\Location;
// use App\Project;
// use App\Follower;

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
        // $this->middleware('auth');
    }

    public function profile(){
        if(Auth::guest()){
            return back()->withErrors(['msg','Please login first']);
        }

    	$user_id = Auth::user()->id;
    	
    	$my_houses = House::get();
    	return view('home.profile');
    }

    public function verify_phone_number(){

        $user = Auth::user();
        return view('auth.verification',['user'=>$user]);
    }

    public function verify_code()
    {
        $this->validate(request(), [
            'verification_code' => 'required|max:4'
        ]);
        $verification_code = request('verification_code');
        $status =  User::where('verified','=','0')->where('verification_code','=',$verification_code)->where('id','=',Auth::user()->id)->exists();

       if($status){
           User::where('verification_code','=',$verification_code)->where('verified','=','0')->where('id','=',Auth::user()->id)->update(['verified'=>'1']);
           $user = Auth::user();
           request()->session()->flash('verification_status', 'Phone Number Verified');
           return view('user.setup', compact('user'));
       }else{
           return back()->withErrors(['verification_code'=>'The Verification Code does not exist']);
       }
    }

    public function setup(){
        if(Auth::guest()){
            return back()->withErrors(['msg','Please login first']);
        }

        $user = Auth::user();
        return view('user.setup', compact('user'));
    }

    function showprofile($id, $page = null){
//        $user = User::with('projects', 'following', 'houses', 'followers')->find($id);
        $user = User::find($id);

        if($page == null){
            if($user->role == "expert" || $user->role == "realtor" || $user->role == "seller")
                $page = "articles";
            else
                $page = "projects";
        }
        
        if(!Auth::guest()){
            $authuser = Auth::user();
            $myProfile = $authuser->id == $user->id;
        }
        else
            $myProfile = false;

        return view('user.userview', compact('page', 'user', 'myProfile'));
    }

    function get_profile_popup($user_id){
        $myProfile = false;
        $followed = 0;

        $user = User::find($user_id);
        if(!Auth::guest()){
            $myProfile = Auth::user()->id == $user->id;

            if(!$myProfile)
                $followed = $user->followed(Auth::user()->id);
        }
        
        $user->followers_count = $user->followers->count();
        $user->houses_count = $user->houses->count();
        $user->projects_count = $user->projects->count();
        $user->followed = $followed;

        return view('user.profile_popup', compact('user', 'myProfile', 'followed'));
    }

    function follow_user(Request $request){
        if(Auth::guest()){
            return back()->withErrors(['msg','Please login first']);
        }

        $authuser = Auth::user();
        $id = $request->input('id');
        $user = User::find($id);
        $followed = $user->followed($authuser->id) ? true : false;
        
        if(!$followed){
            $follow = [
                'user_id' => $authuser->id,
                'followed_id' => $id
            ];

            if(Follows::create($follow)){
                return response()->json([
                    'success' => 'true'
                ]);
            }else{
                return response()->json([
                    'success' => 'true'
                ]);
            }
        }else{
            if(User::find($id)->unfollow($authuser->id)){
                return response()->json([
                    'success' => 'true'
                ]);
            }else{
                return response()->json([
                    'success' => 'false'
                ]);
            }
        }
    }

    function toggle_admin(Request $request){
        if(Auth::guest()){
            return back()->withErrors(['msg','Please login first']);
        }

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

    function become_expert(Request $request){
        if(Auth::guest()){
            return back()->withErrors(['msg','Please login first']);
        }

        $user = User::find(Auth::user()->id);
        $skills_input = $request->get('skill');
        $skills= implode(", ",$skills_input);
        $user->skills = $skills;
        $user->role = "expert";

        if($user->save()){
            $office = [
                "user_id" => Auth::user()->id,
                "name" => $request->input('office_name')
            ];

            $new_office = Office::create($office);
            if($new_office)
                return redirect('office/'.$new_office -> id);
            else
                return back()->withErrors(['msg','Sorry failed to save changes']);
        }
        else
            return back()->withErrors(['msg','Sorry failed to save changes']);
    }

    function setupProfile(Request $request){
        if(Auth::guest()){
            return back()->withErrors(['msg','Please login first']);
        }

        function save_user($user){
            if($user->save()){
                return "success";
            }
            else {
                return response('error!');
            }
        }

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

        if($request->input('location') !== null){
            $location_str = $request->input('location');
            preg_match('/(\S{1,20}).\s(\S{1,20})/', $location_str, $location_array, PREG_OFFSET_CAPTURE);
            $long = $location_array[1];
            $lat = $location_array[2];

            $location_q = Location::where("user_id", $user->id)->first();
            $location = Location::find($location_q->id);
            $location->long = $long[0];
            $location->lat = $lat[0];
            $same_long = $location_q ->long == $long[0];
            $same_lat = $location_q ->lat == $lat[0];

            if($same_long && $same_lat)
                return(save_user($user));

            if($location->save()){
                return(save_user($user));
            }
            else {
                return response("error: Can\'t set location!");
            }
        }else{
            return(save_user($user));
        }
    }

    function clear_notifications(Request $request){
        if(Auth::guest()){
            return response()->json([
                'success' => false,
                'msg' => "Please login first"
            ]);
        }

        $user = Auth::user();
        if($user->unreadNotifications->count() < 1){
            return response()->json([
                'success' => true,
                'msg' => "Notifications cleared!"
            ]);
        }

        $user->unreadNotifications->markAsRead();
        return response()->json([
            'success' => true,
            'msg' => "Notifications cleared!"
        ]);
    }

    function saveDp(Request $request){
        if(Auth::guest()){
            return back()->withErrors(['msg','Please login first']);
        }

        $user = User::find(Auth::user()->id);
        // $path = Storage::put('dps', $request->file('dp'), 'public');
        // $path = $request->file('dp')->store('uploads/dps');

        if($request->file('dp') != null){
            $extension = $request->file('dp')->getClientOriginalExtension();
            $photoName = Auth::user()->id.'_'.time().'.'.$extension;
            $destination = public_path()."/images/uploads/user_dps/";
            $request->file('dp')->move($destination, $photoName);
            $oldDp  = $destination.$user->dp;

            if(file_exists($oldDp))
                unlink($oldDp);
            $user->dp = $photoName;
        }else{
            $user->dp = "def.png";
        }
        
        if($user->save()){
            return "success";
        }
        else {
            return response('error!');
        }
    }
}
