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

Route::get('/', function () {
    return view('welcome');
});

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

Route::get('/profile', function () {
    return view('home.profile');
});

Route::get('/houses', 'HousesController@randomList');
