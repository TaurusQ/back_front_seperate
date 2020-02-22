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

/* 
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::namespace("Admin")->group(function(){

    Route::any('/test',"LoginController@test");

    Route::post('/login', 'LoginController@login');
    Route::post('/refresh', 'LoginController@refresh');

    // 中间件验证 ,multiauth: guard_name
    Route::middleware('multiauth:admin')->group(function () {
        Route::post('/me', 'LoginController@me');
        Route::post('/logout', 'LoginController@logout');
    });

});
