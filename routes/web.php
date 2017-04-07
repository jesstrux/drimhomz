<?php

use App\Libraries\Karibusms;
use App\Message;
use App\Notifications\CommentPosted;
use App\Notifications\PostFaved;
use App\Notifications\PostFollowed;
use Illuminate\Support\Facades\DB;

Route::get('/', 'GuestController@index');

Route::get('/home', 'HomeController@index');

Auth::routes();

Route::get('/dashboard', 'HomeController@dashboard');

Route::get('/notifications', function(){
    if(!Auth::guest()){
        $notifications = Auth::user()->notifications;
//        return $notifications;
        $unread_count = Auth::user()->unreadNotifications->count();
        return view('notifications.index', compact('notifications', 'unread_count'));
    }
});

Route::post('/clearNotifications', 'UserController@clear_notifications');

Route::get('/testUrl/{house_id}/{content}', function ($house_id, $content) {
    if(!Auth::guest()){
         $user = Auth::user();
//         ->full_name();

        $rooms = DB::table('home_utilities')
            ->join('utilities', 'utilities.id', '=', 'home_utilities.utility_id')
            ->join('homes', 'homes.id', '=', 'home_utilities.home_id')
            ->where([
                'homes.id' => 5,
                'utilities.type' => "room",
            ])
            ->select("home_utilities.id", "utilities.type", "utilities.name")
            ->get();

//        $home = App\Home::find(1)->first();
//
        echo json_encode($rooms);
     }
     else{
         echo "Hello guest";
     }
});

Route::get('/house/{id}', function ($id) {
    $house = App\House::with('comments', 'image')->find($id);

    return view('houses.single', compact('house'));
});

Route::get('/getHouse/{id}', function ($id) {
    return App\House::find($id);
});

Route::get('/product/{id}', function ($id) {
    $product = App\Product::find($id);

    return view('products.single', compact('product'));
});

Route::get('resizeImage', 'ImageController@resizeImage');
Route::post('createAd',['as'=>'resizeImagePost','uses'=>'ImageController@resizeImagePost']);

Route::post('createAd','AdminController@create_ad');
Route::post('/deleteAd','AdminController@delete_ad');

Route::get('/about', function () {
    return view('home.about');
});

Route::get('/search', 'SearchController@search');
Route::get('/search/{q}', 'SearchController@search');
Route::get('/search/{q}/{category}', 'SearchController@search_category');

Route::get('/shop', 'ShopController@index');
Route::get('/shop/{id}', 'ShopController@show_profile');

Route::get('/office/{id}', 'OfficeController@show_profile');

Route::get('/expert', 'ExpertController@index');

Route::get('/advice', 'AdviceController@index');
Route::get('/advice/{page}', 'AdviceController@index');

Route::get('/getUser/{id}', function ($id) {
    $user = App\User::find($id);
    $user->project_count = $user->projects->count();
    $user->house_count = $user->houses->count();
    $user->followers_count = $user->followers->count();
    $user->following_count = $user->following->count();

    return $user;
});
Route::get('/user/{id}', 'UserController@showprofile');
Route::get('/user/{id}/{page}', 'UserController@showprofile');
Route::get('/userProfilePopup/{user_id}', 'UserController@get_profile_popup');
Route::post('/followUser', 'UserController@follow_user');
Route::get('/profile', 'UserController@profile');

Route::post('/becomeExpert', 'UserController@become_expert');


Route::get('/project/{id}', 'ProjectsController@showprofile');

Route::get('/editProject/{id}', function ($id) {
    $project = App\Project::find($id);

    return view('project.edit-project', compact('project'));
});

Route::post('/editProject', 'ProjectsController@edit_project');

Route::post('toggle-admin', ['as'=>'/toggleAdmin','uses'=>'UserController@toggle_admin']);

Route::get('/realhomz', function () {
    return redirect('realhomz/homes');
});
Route::get('/realhomz/{page}', 'RealHomzController@index');
Route::get('/realhomz/{page}/{id}', 'RealHomzController@profile');
Route::get('/realhomz/{page}/{id}/new', 'RealHomzController@new_profile');

Route::post('/createHome', 'RealHomzController@create_home');


Route::get('/randomHouses/{page}', 'HousesController@randomList');

Route::post('/registerUser', 'HousesController@reg');

Route::get('/setupAccount', 'UserController@setup');

Route::post('/createProject', 'ProjectsController@store');
Route::post('/createHouse', 'HousesController@store');
Route::post('/pinHouse', 'HousesController@pin_house');
Route::post('/followHouse', 'HousesController@follow_house');

Route::post('setup-account-post', ['as'=>'/setupAccountPost','uses'=>'UserController@setupProfile']);

Route::post('save-dp', ['as'=>'/saveDp','uses'=>'UserController@saveDp']);

Route::get('/comments/{house}', 'HousesController@get_comments');

Route::post('/submitComment', 'HousesController@submit_comment');

Route::post('/favoriteHouse', 'HousesController@favorite_house');
Route::post('/deleteHouse', 'HousesController@delete_house');

Route::post('/favoriteProject', 'ProjectsController@favorite_project');
Route::post('/deleteProject', 'ProjectsController@delete_project')->name('deleteProject');
Route::post('/deleteComment', 'HousesController@delete_comment');
Route::get('/verifyPhoneNumber', 'UserController@verify_phone_number');
Route::post('/verifyCode', 'UserController@verify_code');

Route::get('/codes',function(){
//    $messages = Message::limit(10)->where('sent','=','0')->select('body','phone')->get();
    $messages = Message::limit(10)->where('messages.status', '=', '0')->select('messages.id','messages.body','users.phone','messages.type','users.verification_code','users.id as user_id')
        ->join('users', 'messages.user_id', '=', 'users.id')
        ->get();
   // dd($messages);
    $karibuSMS = new Karibusms();
    foreach ($messages as $message) {
    echo ('Message: '.count($message->id).'-->'. $message->body.' <br>');

        Message::where('user_id', '=', $message->user_id)->where('status', '=', '0')->where('type', '=',$message->type)->where('id', '=', $message->id)->update(['status' => '1']);
        //set a custom name to be used in sending SMS
       // $karibuSMS->set_name("DREAMHOMZ");
        $status = $karibuSMS->send_sms($message->phone,$message->body);

    }
});