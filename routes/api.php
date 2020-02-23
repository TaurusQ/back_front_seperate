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
        Route::get('/admins', 'AdminsController@list')->name('admins.list');
        Route::get('/admins/{permission}', 'AdminsController@show')->name('admins.show');
        Route::post('/admins', 'AdminsController@store')->name('admins.store');
        Route::patch('/admins/{permission}', 'AdminsController@update')->name('admins.update');
        Route::delete('/admins/batch', 'AdminsController@deleteAll')->name('admins.batch_delete');
        Route::delete('/admins/{permission}', 'AdminsController@destroy')->name('admins.destroy');
        Route::post('/admins/assign/{admin}', 'AdminsController@assign')->name('admins.assign');

        // Permissions
        Route::get('/permissions', 'PermissionsController@list')->name('permissions.list');
        Route::get('/permissions/{permission}', 'PermissionsController@show')->name('permissions.show');
        Route::post('/permissions', 'PermissionsController@store')->name('permissions.store');
        Route::patch('/permissions/{permission}', 'PermissionsController@update')->name('permissions.update');
        Route::delete('/permissions/batch', 'PermissionsController@deleteAll')->name('permissions.batch_delete');
        Route::delete('/permissions/{permission}', 'PermissionsController@destroy')->name('permissions.destroy');

        // roles
        Route::get('/roles', 'RolesController@list')->name('roles.list');
        Route::get('/roles/{role}', 'RolesController@show')->name('roles.show');
        Route::post('/roles', 'RolesController@store')->name('roles.store');
        Route::patch('/roles/{role}', 'RolesController@update')->name('roles.update');
        Route::delete('/roles/batch', 'RolesController@deleteAll')->name('roles.batch_delete');
        Route::delete('/roles/{role}', 'RolesController@destroy')->name('roles.destroy');
        Route::post('roles/assign/{role}', 'RolesController@assign')->name('roles.assign');
    
        // admin log
        Route::get('/adminlogs', 'AdminLogsController@list')->name('adminlogs.list');
        Route::get('/adminlogs/{adminlog}', 'AdminLogsController@show')->name('adminlogs.show');
    });
});
