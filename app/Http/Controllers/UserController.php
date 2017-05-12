<?php

namespace App\Http\Controllers;

use App\Message;
use App\Notifications\UserFollowed;
use App\Role;
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
use Illuminate\Support\Facades\Redirect;
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
            'verification_code' => 'required|max:4|exists:users,verification_code',

        ]);
         $verification_code = request('verification_code');

        $verified = User::where('verification_code','=',$verification_code)->where('verified','=','0')->where('id','=',Auth::user()->id)->exists();
        $user = Auth::user();
        if($verified){
            User::where('verification_code','=',$verification_code)->where('verified','=','0')->where('id','=',Auth::user()->id)->update(['verified'=>'1']);
            request()->session()->flash('verification_status', 'Phone Number Successfully Verified');
            request()->session()->flash('verification_type', 'success');
            return view('user.setup', compact('user'));
        }else{

            request()->session()->flash('verification_status', 'Phone Number already Verified!');
            request()->session()->flash('verification_type', 'info');
            return view('user.setup', compact('user'));
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

        if(!$user)
            return Redirect::back();

        if($page == null){
            if($user->hasRole(['expert','realtor','seller']))
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
    function get_subs($user_id, $page){
        $per_page = 12;
        $user = User::find($user_id);
        if($page == "projects"){
            $projects = $user->projects()->orderBy('updated_at', 'desc')->paginate($per_page);

            return response()->json([
                "success" => true,
                "list" => view('user.'.$page.'-list', compact('projects'))->render(),
                "has_more" => $projects->hasMorePages(),
                "next_page_url" => $projects->nextPageUrl()
            ]);
        }else if($page == "houses"){
            $houses = $user->houses()->orderBy('updated_at', 'desc')->paginate($per_page);

            return response()->json([
                "success" => true,
                "list" => view('user.'.$page.'-list', compact('houses'))->render(),
                "has_more" => $houses->hasMorePages(),
                "next_page_url" => $houses->nextPageUrl()
            ]);

        }else if($page == "following"){
            $list = $user->following()->orderBy('updated_at', 'desc')->paginate($per_page);
        }else if($page == "followers"){
            $list = $user->followers()->orderBy('updated_at', 'desc')->paginate($per_page);
        }else if($page == "articles"){
            $list = $user->articles()->orderBy('updated_at', 'desc')->paginate($per_page);
        }else if($page == "reviews"){
            $list = $user->ratings()->orderBy('updated_at', 'desc')->paginate($per_page);
        }else if($page == "shops"){
            $list = $user->shops()->orderBy('updated_at', 'desc')->paginate($per_page);
        }
        else{
            return response()->json([
                "success" => false
            ]);
        }

        return response()->json([
            "success" => true,
            "list" => view('user.'.$page.'-list', compact('list'))->render(),
            "has_more" => $list->hasMorePages(),
            "next_page_url" => $list->nextPageUrl()
        ]);
    }

    function get_profile_popup($user_id){
        $myProfile = false;
        $followed = false;

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

	        $new_follow = Follows::create($follow);
            if($new_follow){
                if(Auth::user()->id != $new_follow->followed_id)
                    User::find($new_follow->followed_id)->notify(new UserFollowed($new_follow->user));

                return response()->json([
                    "success" => "true",
	                "msg" => "Successfully followed user",
	                "followers_count" => $user->followers->count()
                ]);
            }else{
                return response()->json([
                    "success" => "false",
                    "msg" => "Couldn't follow user"
                ]);
            }
        }else{
            if(User::find($id)->unfollow($authuser->id)){
                return response()->json([
                    "success" => "true",
	                "msg" => "Successfully unfollowed user",
	                "followers_count" => $user->followers->count()
                ]);
            }else{
                return response()->json([
                    "success" => "false",
	                "msg" => "Couldn't unfollow user"
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
        $role = Role::where('name','expert')->first();
        $skills_input = $request->get('skill');
        $skills= implode(", ",$skills_input);
        $user->skills = $skills;
        $user->attachRole($role);

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
                return response()->json([
                    'success' => true,
                    'picture_url' => $user->dp,
                    'msg' => "Profile Updated"
                ]);
            }
            else {
                return response()->json([
                    'success' => false,
                    'msg' => "Couldn't save changes!"
                ]);
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
        $user->email = $request->input('email');
        $time = strtotime($request->input('dob'));
        $user->dob = strftime("%Y-%m-%d %H:%M:%S", $time);
        if($request->input('location') !== null){
             return $this->save_location($location_str = $request->input('location'),$user);
        }else{
            return(save_user($user));
        }

    }

    function save_location($location_str,$user){

            $long[] = '';
            $lat[] = '';

            preg_match('/(\S{1,20}).\s(\S{1,20})/', $location_str, $location_array, PREG_OFFSET_CAPTURE);
            if(!empty($location_array)) {
                $long = $location_array[1];
                $lat = $location_array[2];
            }

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
                return response()->json([
                    'success' => false,
                    'msg' => "Couldn't set location"
                ]);
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
            return response()->json([
                'success' => true,
                'picture_url' => $user->dp,
                'msg' => "Picture changed!"
            ]);
        }
        else {
            return response()->json([
                'success' => false
            ]);
        }
    }
}
