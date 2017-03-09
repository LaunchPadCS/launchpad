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
	Route::get('dashboard', 'PageController@dashboard');
	Route::get('settings', 'PageController@showSettings');
	Route::get('settings/picture', 'PageController@showSettingsPicture');
	Route::post('settings', 'PageController@submitSettings');
	Route::post('store', 'PageController@tempProfilePicStore');
	Route::post('crop', 'PageController@cropPicture');
});

// Admin Routes
Route::group(['prefix' => 'admin', 'middleware' => ['role:admin']], function() {
	Route::get('dashboard', 'AdminController@dashboard');
	Route::get('users', 'AdminController@showUsers');
	Route::get('users/edit/{user}', 'AdminController@editUser');
	Route::post('users/edit/{user}', 'AdminController@submitEditUser');
});