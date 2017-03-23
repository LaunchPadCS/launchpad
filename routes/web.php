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
Route::get('application', 'PageController@showApplicationForm');
Route::post('application', 'PageController@submitApplicationForm');

Route::get('datatables', ['as' => 'datatables.data', 'uses' => 'MentorController@getApplications']);

// User Routes
Route::group(['prefix' => 'user', 'middleware' => ['auth']], function () {
    Route::get('dashboard', 'PageController@dashboard');
    Route::get('settings', 'PageController@showSettings');
    Route::get('settings/picture', 'PageController@showSettingsPicture');
    Route::post('settings', 'PageController@submitSettings');
    Route::post('store', 'PageController@tempProfilePicStore');
    Route::post('crop', 'PageController@cropPicture');
});

// Admin Routes
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'role:admin']], function () {
    Route::group(['prefix' => 'application'], function () {
        Route::get('form', 'AdminController@showApplicationForm');
        Route::post('form/order', 'AdminController@submitQuestionOrder');
        Route::post('question/delete/{question?}', 'AdminController@deleteQuestion');
        Route::post('question/edit/{question?}', 'AdminController@updateQuestion');
        Route::post('question/create', 'AdminController@createQuestion');
        Route::post('submitDecision', 'AdminController@submitDecision');
    });

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', 'AdminController@showUsers');
        Route::get('edit/{user}', 'AdminController@editUser');
        Route::post('edit/{user}', 'AdminController@submitEditUser');
        Route::post('disable/{user?}', 'AdminController@disableAccount');
    });

    Route::group(['prefix' => 'interview'], function () {
        Route::get('create', 'AdminController@showCreateInterview');
        Route::get('assign', 'AdminController@showAssignInterview');
        Route::post('assign/{interviewslot?}', 'AdminController@submitAssignment');
        Route::post('createBulk', 'AdminController@submitBulkCreateInterview');
        Route::post('create', 'AdminController@submitCreateInterview');
        Route::post('form', 'AdminController@submitTimeslot');
    });
});

// Mentor Routes
Route::group(['prefix' => 'mentor', 'middleware' => ['auth', 'role:admin|mentor']], function () {
    Route::get('applications', 'MentorController@showApplications');
    Route::get('rate/{id?}', 'MentorController@showRate');
    Route::post('rate/submit', 'MentorController@submitRating');
});
