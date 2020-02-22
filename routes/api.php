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

Route::namespace("Admin")->name("api.")->prefix("admin")->group(function () {

    Route::any('/test', "LoginController@test");

    Route::post('/login', 'LoginController@login');
    Route::post('/refresh', 'LoginController@refresh');

    // 中间件验证 ,multiauth: guard_name
    Route::middleware('multiauth:admin')->name("admin.")->group(function () {
        Route::post('/me', 'LoginController@me');
        Route::post('/logout', 'LoginController@logout');

        // Admins
        Route::get('/admins','AdminsController@list')->name('admins.list');

        // Permissions
        Route::get('/permissions', 'PermissionsController@list')->name('permissions.list');
        Route::get('/permissions/{permission}', 'PermissionsController@show')->name('permissions.show');
        Route::post('/permissions', 'PermissionsController@store')->name('permissions.store');
        Route::patch('/permissions/{permission}', 'PermissionsController@update')->name('permissions.update');
        Route::delete('/permissions/{permission}','PermissionsController@destroy')->name('permissions.destroy');
        Route::delete('/permissions/batch_delete','PermissionsController@deleteAll')->name('permissions.batch_delete');
    });
});
