<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::resource(
    'videos', 'VideoController',
    [ 'except' => ['create', 'edit'] ]
);

Route::resource(
    'channels', 'ChannelController',
    [ 'except' => ['create', 'edit'] ]
);

Route::resource(
    'comments', 'CommentController',
    [ 'except' => ['create', 'edit'] ]
);

Route::resource(
    'plans', 'PlanController',
    [ 'except' => ['edit'] ]
);

Route::get('/search', [
    'as' => 'api.search',
    'uses' => 'Api\SearchController@search'
]);

Route::get('/cancel', [
    'as' => 'api.cancel',
    'uses' => 'PlanController@cancelSubscription'
]);

Route::get('/resume', [
    'as' => 'api.resume',
    'uses' => 'PlanController@resumeSubscription'
]);

Route::get('/isUserSubscribed', [
    'as' => 'api.isUserSubscribed',
    'uses' => 'PlanController@checkSubscription'
])->middleware('auth:api');

Route::post('/changepassword', [
    'as' => 'api.changepassword',
    'uses' => 'PlanController@changepassword'
])->middleware('auth:api');

Route::get('/sendemail', [
    'as' => 'api.sendemail',
    'uses' => 'EmailController@sendEmail'
])->middleware('auth:api');


Route::get('/deleteaccount', [
    'as' => 'api.deleteaccount',
    'uses' => 'UsersController@delete_account'
])->middleware('auth:api');

Route::post('/charge', [
    'as' => 'api.charge',
    'uses' => 'PlanController@store'
])->middleware('auth:api');

Route::post('/uploadprofileimage', [
    'as' => 'api.uploadprofileimage',
    'uses' => 'UsersController@update_avatar'
])->middleware('auth:api');

// Route::get('/checkout', [
//     'as' => 'api.checkout',
//     'uses' => 'UsersController@checkoutuser'
// ])->middleware('auth:api');

// Get current user
Route::get('/me', function (Request $request) {
    return $request->user();
})->middleware('auth:api');


