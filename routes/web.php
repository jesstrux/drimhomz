<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'GuestController@index');

Route::get('/home', 'HomeController@index');

Auth::routes();

Route::get('/dashboard', 'HomeController@dashboard');

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

Route::get('/profile', 'UserController@profile');

Route::get('/randomHouses/{page}', 'HousesController@randomList');

Route::post('/registerUser', 'HousesController@reg');

Route::get('/setupAccount', 'UserController@setup');

Route::post('setup-account-post', ['as'=>'/setupAccountPost','uses'=>'UserController@setupProfile']);
Route::post('save-dp', ['as'=>'/saveDp','uses'=>'UserController@saveDp']);