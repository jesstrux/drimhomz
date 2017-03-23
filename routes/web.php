<?php

Route::get('/', 'GuestController@index');

Route::get('/home', 'HomeController@index');

Auth::routes();

Route::get('/dashboard', 'HomeController@dashboard');

Route::get('/testUrl/{user_id}/{follower}', function ($user_id, $follower) {
    // if(!Auth::guest())
    //     echo Auth::user()->full_name();
    // else
    //  echo "Hello guest";

 	$project = App\House::find($user_id);
    print_r($project->owner()->fname);
});

Route::get('/house/{id}', function ($id) {
    $house = App\House::find($id);

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
Route::post('resizeImagePost',['as'=>'resizeImagePost','uses'=>'ImageController@resizeImagePost']);


Route::get('/about', function () {
    return view('home.about');
});

Route::get('/search', 'SearchController@search');
Route::get('/search/{q}', 'SearchController@search');
Route::get('/search/{q}/{category}', 'SearchController@search_category');

Route::get('/shop', 'ShopController@index');
Route::get('/shop/{id}', 'ShopController@show_profile');

Route::get('/expert', 'ExpertController@index');

Route::get('/advice', 'AdviceController@index');
Route::get('/advice/{page}', 'AdviceController@index');

Route::get('/user/{id}', 'UserController@showprofile');
Route::get('/user/{id}/{page}', 'UserController@showprofile');

Route::get('/project/{id}', 'ProjectsController@showprofile');

Route::get('/userProfilePopup/{user_id}', 'UserController@get_profile_popup');

Route::post('toggle-admin', ['as'=>'/toggleAdmin','uses'=>'UserController@toggle_admin']);

Route::post('/followUser', 'UserController@follow_user');


Route::get('/profile', 'UserController@profile');

Route::get('/realhomz', function () {
    return view('home.realhomz');
});

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