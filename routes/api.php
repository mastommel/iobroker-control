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

Route::namespace('Api')->group(function () {
    Route::post('/state', 'StateChangedController@index')
        ->name('api.state_changed');

    Route::get('/devices', 'DevicesController@index')
        ->name('api.devices.index');

    Route::post('/state/update', 'StateController@update')
        ->name('api.state.update');
});
