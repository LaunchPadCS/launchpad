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

Auth::routes();

// Public Routes
Route::get('/', 'PageController@index');

// User Routes
Route::group(['prefix' => 'user', 'middleware' => ['auth']], function() {
	Route::get('/dashboard', 'PageController@dashboard');
	Route::get('settings', 'PageController@showSettings');
	Route::get('settings/picture', 'PageController@showSettingsPicture');
	Route::post('settings', 'PageController@submitSettings');
	Route::post('store', 'PageController@tempProfilePicStore');
	Route::post('crop', 'PageController@cropPicture');
});