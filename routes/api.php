<?php

Route::prefix('v1')->namespace('Api')->group(function () {
    Route::prefix('conta')->group(function () {
        Route::post('/login', 'AtenticacaoController@login');
        Route::post('/logout', 'AtenticacaoController@logout');
        Route::post('/criar', 'AtenticacaoController@store');
    });
});

Route::prefix('v1')->namespace('Api')->middleware('auth:api')->group(function () {

    Route::name('real_states.')->group(function () {
        Route::resource('real-states', 'RealStateController'); //api/v1/real-state
    });

    Route::name('users.')->group(function () {
        Route::resource('users', 'UserController'); //api/v1/real-state
    });

    Route::name('categorys')->group(function () {
        Route::get('categorys/{id}/real-states', 'CategoryController@realState');
        Route::resource('categorys', 'CategoryController');
    });

    route::name('photo.')->prefix('photos')->group(function () {
        Route::delete('/{id}', 'RealStatePhotoController@remove')->name('delete');
        Route::put('/set-thumb/{photoId}/{realStateId}', 'RealStatePhotoController@setThumb')->name('setThumb');
    });
});
