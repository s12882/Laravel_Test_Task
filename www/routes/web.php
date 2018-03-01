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

Route::get('/', function () {
    redirect()->route('login');
});

Route::group(['namespace' => 'Auth'], function () {
    Route::get('login', 'LoginController@index')->name('login');
    Route::post('login', 'LoginController@login')->name('post.login');
    Route::get('logout', 'LoginController@logout')->name('logout');

    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.reset_form');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset')->name('password.request');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'HomeController@index')->name('home');

    Route::group(['prefix' => 'user'], function () {
        Route::group(['middleware' => 'permission:list users'], function () {
            Route::post('datatables', 'UserController@datatables')->name('user.datatables');
            Route::get('datatables', 'UserController@datatables')->name('user.datatables');
            Route::get('', 'UserController@index')->name('user.index');
        });
        Route::group(['middleware' => 'permission:acivate/deactivate users'], function () {
            Route::get('/{user}/activate', 'UserController@activate')->name('user.activate');
            Route::get('/{user}/deactivate', 'UserController@deactivate')->name('user.deactivate');
        });
        Route::group(['middleware' => 'permission:create user'], function () {
            Route::get('create', 'UserController@create')->name('user.create');
            Route::post('', 'UserController@store')->name('user.store');
        });
        Route::patch('/{user}', 'UserController@update')->name('user.update');
        Route::get('/{id}', function(){throw new \ErrorException();});
        Route::get('/{user}/edit', 'UserController@edit')->name('user.edit')->middleware('permission:update user');
        Route::delete('/{id}', 'UserController@destroy')->name('user.destroy')->middleware('permission:delete user');
    });

    Route::group(['prefix' => 'role'], function(){
        Route::group(['middleware' => 'permission:list roles'], function(){
          Route::post('/datatables', 'RoleController@datatables')->name('role.datatables');
          Route::get('', 'RoleController@index')->name('role.index');
        });
        Route::group(['middleware' => 'permission:create role'], function(){
          Route::get('create', 'RoleController@create')->name('role.create');
          Route::post('', 'RoleController@store')->name('role.store');
        });
        Route::group(['middleware' => 'permission:update role'], function () {
            Route::get('/{role}/edit', 'RoleController@edit')->name('role.edit');
            Route::patch('/{role}', 'RoleController@update')->name('role.update');
        });
        Route::get('/{id}', function(){throw new \ErrorException();});
        Route::delete('/{id}', 'RoleController@destroy')->name('role.destroy')->middleware('permission:delete role');
    });

      Route::group(['prefix' => 'news'], function(){
        Route::get('', 'NewsController@index')->name('news.index');
        Route::post('/datatables', 'NewsController@datatables')->name('news.datatables');
        
        Route::group(['middleware' => 'permission:create news'], function(){
            Route::get('/create', 'NewsController@create')->name('news.create');
            Route::post('', 'NewsController@store')->name('news.store');
        });
        
        Route::group(['middleware' => 'permission:update news'], function(){
            Route::get('/{news}/edit', 'NewsController@edit')->name('news.edit');
            Route::patch('/{news}', 'NewsController@update')->name('news.update');
        });
        
        Route::get('/{news}', 'NewsController@show')->name('news.show');
        Route::delete('/{id}', 'NewsController@destroy')->name('news.destroy')->middleware('permission:delete news');
        Route::delete('destroy_image/{id}', 'NewsController@destroy_image')->name('news.destroy_image');
        Route::get('download_file/{id}', 'NewsController@download_image')->name('news.download_image');
    });

    Route::group(['prefix' => 'resp'], function(){
        Route::get('', 'ResponseController@index')->name('resp.index');
        Route::post('/datatables', 'ResponseController@datatables')->name('resp.datatables');
        
        Route::group(['middleware' => 'permission:create resp'], function(){
            Route::get('/create', 'ResponseController@create')->name('resp.create');
            Route::post('', 'ResponseController@store')->name('resp.store');
        });
        
        Route::group(['middleware' => 'permission:update resp'], function(){
            Route::get('/{resp}/edit', 'ResponseController@edit')->name('resp.edit');
            Route::patch('/{resp}', 'ResponseController@update')->name('resp.update');
        });
        
        Route::get('/{resp}', 'ResponseController@show')->name('resp.show');
        Route::delete('/{id}', 'ResponseController@destroy')->name('resp.destroy')->middleware('permission:delete resp');
    });

    Route::group(['prefix' => 'comment'], function(){
        Route::post('all', 'CommentController@getComments')->name('comment.all');
        Route::post('new', 'CommentController@getNewComments')->name('comment.new');
        Route::post('comment', 'CommentController@store')->name('comment.store');
        Route::delete('{id}', 'CommentController@destroy')->name('comment.destroy');
    });

    Route::get('profile', 'UserController@profile')->name('profile.index');
    Route::get('profile#edit', 'UserController@profile')->name('profile.edit');

});
