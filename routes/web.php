<?php

use App\Libraries\Karibusms;
use App\Message;
use App\Notifications\CommentPosted;
use App\Notifications\PostFaved;
use App\Notifications\PostFollowed;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

Route::get('/', 'GuestController@index');

Route::get('/home', 'HomeController@index');

Auth::routes();

Route::get('/dashboard',['as'=>'dashboard','uses'=>'HomeController@dashboard','middleware' => ['permission:ad-create']]);

Route::get('/notifications', function () {
    if (!Auth::guest()) {
        $notifications = Auth::user()->notifications;
//        return $notifications;
        $unread_count = Auth::user()->unreadNotifications->count();
        return view('notifications.index', compact('notifications', 'unread_count'));
    }
});

Route::post('/clearNotifications', 'UserController@clear_notifications');
Route::get('/clearOneNotification/{id}', 'NotificationController@clear_one_notification');

Route::get('/testUrl/{house_id}/{content}', function ($house_id, $content) {
    $user = App\User::find(1);
    $rating = $user->ratings();
    return $rating->get();

    if (!Auth::guest()) {
        $user = Auth::user();
//         ->full_name();

//	    return App\User::find(1)
//		    ->ratings()
//		    ->join()
//		    ->get();

//	    return App\Home::find(31)->images->toJson();
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

Route::get('/product/{id}', 'ProductController@index');
Route::post('/createProduct', 'ProductController@store');

Route::get('resizeImage', 'ImageController@resizeImage');
Route::post('createAd', ['as' => 'resizeImagePost', 'uses' => 'ImageController@resizeImagePost']);

Route::post('createAd', 'AdminController@create_ad');
Route::post('/deleteAd', 'AdminController@delete_ad');

Route::get('/about', function () {
    return view('home.about');
});

Route::post('/rateIt', 'RatingController@rate');

Route::get('/search', 'SearchController@search');
Route::get('/search/{q}', 'SearchController@search');
Route::get('/search/{q}/{category}', 'SearchController@search_category');

Route::get('/shop', 'ShopController@index');
Route::get('/shop/{id}', 'ShopController@show_profile');
Route::post('/createShop', 'ShopController@store');

Route::get('/office/{id}', 'OfficeController@show_profile');

Route::get('/expert', 'ExpertController@index');
Route::post('/rateExpert', 'ExpertController@rate_expert');

Route::get('/advice', 'AdviceController@index');
Route::get('/advice/{page}', 'AdviceController@index');
Route::get('/advice/{page}/{slug}', 'AdviceController@single');
Route::post('/createQuestion','AdviceController@create_question');
Route::post('/createArticle','AdviceController@create_article');
Route::post('/submitAnswer', 'AdviceController@submit_answer');
Route::post('/submitArticleComment', 'AdviceController@submit_comment');
Route::post('/removeAnswer', 'AdviceController@remove_answer');
Route::post('/removeComment', 'AdviceController@remove_comment');

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
Route::get('/user_dp/{id}', function($id){
    $user = App\User::find($id);
    $storage_url = asset("images/uploads/") . "/user_dps/" . $user->dp;

    return '<img class="img-circle dropdown-avatar" src="' .$storage_url. '" alt="'. $user->fname .'\'s image" />';
});
Route::get('/userProfilePopup/{user_id}', 'UserController@get_profile_popup');
Route::post('/followUser', 'UserController@follow_user');
Route::get('/profile', 'UserController@profile');
Route::get('/userSubs/{user_id}/{page}', 'UserController@get_subs');

Route::post('/becomeExpert', 'UserController@become_expert');


Route::get('/project/{id}', 'ProjectsController@showprofile');

Route::get('/editProject/{id}', function ($id) {
    $project = App\Project::find($id);

    return view('project.edit-project', compact('project'));
});

Route::post('/editProject', 'ProjectsController@edit_project');

Route::post('toggle-admin', ['as' => '/toggleAdmin', 'uses' => 'UserController@toggle_admin']);

Route::get('/realhomz', function () {
    return redirect('realhomz/homes');
});

Route::get('/realhomz/{page}', 'RealHomzController@index');
Route::post('/createHome', 'RealHomzController@create_home');
Route::post('/createPlot', 'RealHomzController@create_plot');
Route::post('/createRental', 'RealHomzController@create_rental');
Route::get('/realhomz/{page}/{id}', 'RealHomzController@profile');
Route::get('/realhomz/{page}/{id}/new', 'RealHomzController@new_profile');
Route::get('/missingUtilities/{home_id}/{table}', function ($home_id, $table) {
    $existing_rooms = DB::table($table . "_utilities")
        ->where($table . "_id", $home_id)->pluck('utility_id');
    return $rooms = App\Utility::whereNotIn('id', $existing_rooms)->select("id", "name", "type")->get();;
});
Route::post('/addRoomsToHome', 'RealHomzController@add_rooms_to_home');
Route::post('/addRoomsToRental', 'RealHomzController@add_rooms_to_rental');
Route::post('/removeRoomFromHome', 'RealHomzController@remove_room_from_home');
Route::post('/removeRoomFromRental', 'RealHomzController@remove_room_from_rental');
Route::post('/addPicturesToHome', 'RealHomzController@add_pictures_to_home');
Route::post('/addPicturesToRental', 'RealHomzController@add_pictures_to_rental');
Route::post('/addPicturesToPlot', 'RealHomzController@add_pictures_to_plot');

Route::get('/randomHouses/{page}', 'HousesController@randomList');

Route::get('/randomFeaturedHouses', 'HousesController@houseList');

Route::post('/registerUser', 'HousesController@reg');

Route::get('/setupAccount', 'UserController@setup');

Route::post('/createProject', 'ProjectsController@store');
Route::post('/createHouse', 'HousesController@store');
Route::post('/pinHouse', 'HousesController@pin_house');
Route::post('/followHouse', 'HousesController@follow_house');

Route::post('setup-account-post', ['as' => '/setupAccountPost', 'uses' => 'UserController@setupProfile']);


Route::post('save-dp', ['as'=>'/saveDp','uses'=>'UserController@saveDp']);
Route::post('/saveDp', 'UserController@saveDp');

Route::get('/comments/{house}', 'HousesController@get_comments');

Route::post('/submitComment', 'HousesController@submit_comment');

Route::post('/favoriteHouse', 'HousesController@favorite_house');
Route::post('/deleteHouse', 'HousesController@delete_house');

Route::post('/favoriteProject', 'ProjectsController@favorite_project');
Route::post('/deleteProject', 'ProjectsController@delete_project')->name('deleteProject');
Route::post('/deleteComment', 'HousesController@delete_comment');
Route::get('/verifyPhoneNumber', 'UserController@verify_phone_number');
Route::post('/verifyCode', 'UserController@verify_code');


/*User Roles*/
Route::group(['middleware' => ['auth']], function() {


    Route::get('users',['as'=>'users.index','uses'=>'UsersController@index','middleware' => ['permission:user-list|user-create|user-edit|user-delete']]);
    Route::get('users/create',['as'=>'users.create','uses'=>'UsersController@create','middleware' => ['permission:user-create']]);
    Route::post('users/create',['as'=>'users.store','uses'=>'UsersController@store','middleware' => ['permission:user-create']]);
    Route::get('users/{id}',['as'=>'users.show','uses'=>'UsersController@show']);
    Route::get('users/{id}/edit',['as'=>'users.edit','uses'=>'UsersController@edit','middleware' => ['permission:user-edit']]);
    Route::patch('users/{id}',['as'=>'users.update','uses'=>'UsersController@update','middleware' => ['permission:user-edit']]);
    Route::delete('users/{id}',['as'=>'users.destroy','uses'=>'UsersController@destroy','middleware' => ['permission:user-delete']]);

    Route::get('roles',['as'=>'roles.index','uses'=>'RoleController@index','middleware' => ['permission:role-list|role-create|role-edit|role-delete']]);
    Route::get('roles/create',['as'=>'roles.create','uses'=>'RoleController@create','middleware' => ['permission:role-create']]);
    Route::post('roles/create',['as'=>'roles.store','uses'=>'RoleController@store','middleware' => ['permission:role-create']]);
    Route::get('roles/{id}',['as'=>'roles.show','uses'=>'RoleController@show']);
    Route::get('roles/{id}/edit',['as'=>'roles.edit','uses'=>'RoleController@edit','middleware' => ['permission:role-edit']]);
    Route::patch('roles/{id}',['as'=>'roles.update','uses'=>'RoleController@update','middleware' => ['permission:role-edit']]);
    Route::delete('roles/{id}',['as'=>'roles.destroy','uses'=>'RoleController@destroy','middleware' => ['permission:role-delete']]);

    Route::get('adCRUD',['as'=>'adCRUD.index','uses'=>'adCRUDController@index','middleware' => ['permission:ad-list|ad-create|ad-edit|ad-delete']]);
    Route::get('adCRUD/create',['as'=>'adCRUD.create','uses'=>'adCRUDController@create','middleware' => ['permission:ad-create']]);
    Route::post('adCRUD/create',['as'=>'adCRUD.store','uses'=>'adCRUDController@store','middleware' => ['permission:ad-create']]);
    Route::get('adCRUD/{id}',['as'=>'adCRUD.show','uses'=>'adCRUDController@show']);
    Route::get('adCRUD/{id}/edit',['as'=>'adCRUD.edit','uses'=>'adCRUDController@edit','middleware' => ['permission:ad-edit']]);
    Route::patch('adCRUD/{id}',['as'=>'adCRUD.update','uses'=>'adCRUDController@update','middleware' => ['permission:ad-edit']]);
    Route::delete('adCRUD/{id}',['as'=>'adCRUD.destroy','uses'=>'adCRUDController@destroy','middleware' => ['permission:ad-delete']]);
});



//This Functions only applies to a specific user who resends verification code for phone number verification
Route::get('/resendCode', function () {
     $messages = Message::limit(1)->where('messages.status', '>=', '0')->where('messages.user_id', '=', Auth::user()->id)->select('messages.id', 'messages.body', 'users.phone', 'messages.type', 'users.verification_code', 'users.id as user_id')
        ->join('users', 'messages.user_id', '=', 'users.id')
        ->get();
    $karibuSMS = new Karibusms();
    if (!$messages->isEmpty()) {
        foreach ($messages as $message) {

            Message::where('user_id', '=', $message->user_id)->where('status', '>=', '0')->where('type', '=', $message->type)->where('id', '=', $message->id)->increment('status');

            //set a custom name to be used in sending SMS
            $karibuSMS->set_name("DREAMHOMZ");
             $status = $karibuSMS->send_sms($message->phone, $message->body);

        }
        //call_in_background("schedule:run");
        return response()->json(['status' => 'success', 'message' => 'Your Verification Code has been sent to your Phone Number']);
    }
    return response()->json(['status' => 'error', 'message' => 'Looks like the Verification Code was sent before']);
});