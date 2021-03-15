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

//Admin routes

Route::prefix('/admin')->namespace('Admin')->name('admin.')->group(function(){
    
    //Routes for IndexController
    Route::get('/','IndexController@index')->name('index.index');
    
    //Routes for UsersController
    Route::prefix('/users')->name('users.')->group(function(){
        Route::get('/','UsersController@index')->name('index');
        Route::post('/datatable','UsersController@datatable')->name('datatable');
        Route::get('/create','UsersController@create')->name('create');
        Route::post('/store','UsersController@store')->name('store');
        Route::get('/edit/{user}','UsersController@edit')->name('edit');
        Route::post('/update/{user}','UsersController@update')->name('update');
        Route::post('/delete-photo','UsersController@deletePhoto')->name('delete_photo');
        Route::post('/active','UsersController@active')->name('active');
        Route::post('/ban','UsersController@ban')->name('ban');
    });
    
});
