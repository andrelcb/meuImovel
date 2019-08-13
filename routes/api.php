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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->namespace('Api')->group(function() {

    Route::name('real_states.')->group(function() {
        Route::resource('real-states', 'RealStateController'); //api/v1/real-state
    });

    Route::name('users.')->group(function() {
        Route::resource('users', 'UserController'); //api/v1/real-state
    });

    Route::name('categorys')->group(function() {
        Route::get('categorys/{id}/real-states', 'CategoryController@realState');
        Route::resource('categorys', 'CategoryController');
    });

    route::name('photo.')->prefix('photos')->group(function() {
        Route::delete('/{id}', 'RealStatePhotoController@remove')->name('delete');
        Route::put('/set-thumb/{photoId}/{realStateId}', 'RealStatePhotoController@setThumb')->name('setThumb');
    });
});
