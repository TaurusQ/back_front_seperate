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

Route::any('/upload/{file_type}/{category}','UploadController@commonUpload');

// 测试图片上传
Route::any('/upload_test','UploadController@testUpload');

Route::namespace("Admin")->name("api.")->prefix("admin")->group(function () {

    Route::any('/test', "LoginController@test");

    Route::post('/login', 'LoginController@login');
    Route::post('/refresh', 'LoginController@refresh'); 

    // 中间件验证 ,multiauth: guard_name
    Route::middleware('multiauth:admin')->name("admin.")->group(function () {
        Route::get('/me', 'LoginController@me');
        Route::post('/logout', 'LoginController@logout');

        // Admins
        Route::get('/admins/field_map','AdminsController@getResponseStatus')->name('admins.field_map');
        Route::get('/admins', 'AdminsController@list')->name('admins.list');
        Route::get('/admins/{admin}', 'AdminsController@show')->name('admins.show');
        Route::post('/admins', 'AdminsController@store')->name('admins.store');
        Route::patch('/admins/{admin}', 'AdminsController@update')->name('admins.update');
        Route::delete('/admins/batch', 'AdminsController@deleteAll')->name('admins.batch_delete');
        Route::delete('/admins/{admin}', 'AdminsController@destroy')->name('admins.destroy');
        Route::post('/admins/assign/{admin}', 'AdminsController@assign')->name('admins.assign');

        Route::post('/admins/reset/{admin}', 'AdminsController@reset')->name('admins.reset');
        Route::post('/admins/modify/password', 'AdminsController@modify_password')->name('admins.modify.password');
        
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
    
        // app notice
        //Route::get('/app_notices/type','AppNoticeController@getAccessType')->name('app_notices.type');
        Route::get('/app_notices/field_map','AppNoticeController@getResponseStatus')->name('app_notices.field_map');
        Route::get('/app_notices', 'AppNoticeController@list')->name('app_notices.list');
        Route::get('/app_notices/{app_notice}', 'AppNoticeController@show')->name('app_notices.show');
        Route::post('/app_notices', 'AppNoticeController@store')->name('app_notices.store');
        Route::patch('/app_notices/{app_notice}', 'AppNoticeController@update')->name('app_notices.update');
        Route::delete('/app_notices/batch', 'AppNoticeController@deleteAll')->name('app_notices.batch_delete');
        Route::delete('/app_notices/{app_notice}', 'AppNoticeController@destroy')->name('app_notices.destroy');
        
        // article
        Route::get('/articles/field_map','ArticlesController@getResponseStatus')->name('articles.field_map');
        // Route::get('/articles/access_type','ArticlesController@getAccessType')->name('articles.type');
        Route::get('/articles', 'ArticlesController@list')->name('articles.list');
        Route::get('/articles/{article}', 'ArticlesController@show')->name('articles.show');
        Route::post('/articles', 'ArticlesController@store')->name('articles.store');
        Route::patch('/articles/{article}', 'ArticlesController@update')->name('articles.update');
        Route::delete('/articles/batch', 'ArticlesController@deleteAll')->name('articles.batch_delete');
        Route::delete('/articles/{article}', 'ArticlesController@destroy')->name('articles.destroy');
        
        // article categories
        Route::get('/article_categories', 'ArticleCategoriesController@list')->name('article_categories.list');
        Route::get('/article_categories/{article}', 'ArticleCategoriesController@show')->name('article_categories.show');
        //Route::post('/article_categories', 'ArticleCategoriesController@store')->name('article_categories.store');
        Route::patch('/article_categories/{article}', 'ArticleCategoriesController@update')->name('article_categories.update');
        Route::delete('/article_categories/batch', 'ArticleCategoriesController@deleteAll')->name('article_categories.batch_delete');
        Route::delete('/article_categories/{article}', 'ArticleCategoriesController@destroy')->name('article_categories.destroy');
        
        // system config 
        Route::get('/system_configs/group','SystemConfigsController@getConfigGroup')->name('system_configs.group');
        Route::get('/system_configs', 'SystemConfigsController@list')->name('system_configs.list');
        Route::get('/system_configs/{system_config}', 'SystemConfigsController@show')->name('system_configs.show');
        Route::post('/system_configs', 'SystemConfigsController@store')->name('system_configs.store');
        Route::patch('/system_configs/{system_config}', 'SystemConfigsController@update')->name('system_configs.update');
        Route::delete('/system_configs/batch', 'SystemConfigsController@deleteAll')->name('system_configs.batch_delete');
        Route::delete('/system_configs/{system_config}', 'SystemConfigsController@destroy')->name('system_configs.destroy');
        
        // status map
        Route::get('/status_maps', 'StatusMapsController@list')->name('status_maps.list');
        Route::get('/status_maps/{status_map}', 'StatusMapsController@show')->name('status_maps.show');
        Route::post('/status_maps', 'StatusMapsController@store')->name('status_maps.store');
        Route::patch('/status_maps/{status_map}', 'StatusMapsController@update')->name('status_maps.update');
        Route::delete('/status_maps/batch', 'StatusMapsController@deleteAll')->name('status_maps.batch_delete');
        Route::delete('/status_maps/{status_map}', 'StatusMapsController@destroy')->name('status_maps.destroy');
        

        // attachment
        Route::get('/attachments', 'AttachmentsController@list')->name('attachments.list');
        Route::get('/attachments/{attachment}', 'AttachmentsController@show')->name('attachments.show');
        //Route::post('/attachments', 'AttachmentsController@store')->name('attachments.store');
        Route::patch('/attachments/{attachment}', 'AttachmentsController@update')->name('attachments.update');
        Route::delete('/attachments/batch', 'AttachmentsController@deleteAll')->name('attachments.batch_delete');
        Route::delete('/attachments/{attachment}', 'AttachmentsController@destroy')->name('attachments.destroy');
        
    });
});

Route::namespace("User")->name("api.")->prefix("user")->group(function () {

    Route::post('/login', 'LoginController@login');
    Route::post('/refresh', 'LoginController@refresh');

    Route::middleware('multiauth:user')->name("user.")->group(function () {
        Route::post('/me', 'LoginController@me');
        Route::post('/logout', 'LoginController@logout');
        Route::post('/refresh','LoginController@refersh');
    });
});
