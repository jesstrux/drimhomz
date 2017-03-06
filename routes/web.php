<?php

Route::get('/', 'GuestController@index');

Route::get('/home', 'HomeController@index');

Auth::routes();

Route::get('/dashboard', 'HomeController@dashboard');

Route::get('/testUrl/{followed}/{follower}', function ($followed, $follower) {
	if(!Auth::guest())
        return Auth::user()->full_name();
	else
		return "Hello guest";
});


Route::get('/about', function () {
    return view('home.about');
});

Route::get('/shop', function () {
    return view('home.shop');
});

Route::get('/expert', function () {
    return view('home.expert');
});

Route::get('/advice', function () {
    return view('home.advice');
});

Route::get('/user/{id}', 'UserController@showprofile');

Route::post('toggle-admin', ['as'=>'/toggleAdmin','uses'=>'UserController@toggle_admin']);

Route::post('/followUser', 'UserController@follow_user');


Route::get('/profile', 'UserController@profile');

Route::get('/randomHouses/{page}', 'HousesController@randomList');

Route::post('/registerUser', 'HousesController@reg');

Route::get('/setupAccount', 'UserController@setup');

Route::post('setup-account-post', ['as'=>'/setupAccountPost','uses'=>'UserController@setupProfile']);

Route::post('save-dp', ['as'=>'/saveDp','uses'=>'UserController@saveDp']);

Route::get('/comments/{house}', 'HousesController@get_comments');

Route::post('/submitComment', 'HousesController@submit_comment');

Route::post('/favoriteHouse', 'HousesController@favorite_house');

Route::post('/deleteComment', 'HousesController@delete_comment');