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

Route::middleware('auth')->prefix('/admin')->namespace('Admin')->name('admin.')->group(function(){
    
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
    
    //Routes for ProfileController
    Route::prefix('/profile')->name('profile.')->group(function(){
        Route::get('/edit','ProfileController@edit')->name('edit');
        Route::post('/update','ProfileController@update')->name('update');
        Route::get('/show-change-password','ProfileController@showChangePassword')->name('show_change_password');
        Route::post('/change-password','ProfileController@changePassword')->name('change_password');
        Route::post('/delete-photo','ProfileController@deletePhoto')->name('delete_photo');
    });
    
    //Routes for TagsController
    Route::prefix('/tags')->name('tags.')->group(function(){
        Route::get('/','TagsController@index')->name('index');
        Route::post('/datatable','TagsController@datatable')->name('datatable');
        Route::get('/create','TagsController@create')->name('create');
        Route::post('/store','TagsController@store')->name('store');
        Route::get('/edit/{tag}','TagsController@edit')->name('edit');
        Route::post('/update/{tag}','TagsController@update')->name('update');
        Route::post('/delete','TagsController@delete')->name('delete');
    });
    
    //Routes for CategoriesController
    Route::prefix('/categories')->name('categories.')->group(function(){
        Route::get('/','CategoriesController@index')->name('index');
        Route::post('/datatable','CategoriesController@datatable')->name('datatable');
        Route::get('/create','CategoriesController@create')->name('create');
        Route::post('/store','CategoriesController@store')->name('store');
        Route::get('/edit/{category}','CategoriesController@edit')->name('edit');
        Route::post('/update/{category}','CategoriesController@update')->name('update');
        Route::post('/change-priorities','CategoriesController@changePriorities')->name('change_priorities');
        Route::post('/delete','CategoriesController@delete')->name('delete');
    });
    
    //Routes for BlogPostsController
    Route::prefix('/blog-posts')->name('blog_posts.')->group(function(){
        Route::get('/','BlogPostsController@index')->name('index');
        Route::post('/datatable','BlogPostsController@datatable')->name('datatable');
        Route::get('/create','BlogPostsController@create')->name('create');
        Route::post('/store','BlogPostsController@store')->name('store');
        Route::get('/edit/{blogPost}','BlogPostsController@edit')->name('edit');
        Route::post('/update/{blogPost}','BlogPostsController@update')->name('update');
        Route::post('/enable','BlogPostsController@enable')->name('enable');
        Route::post('/disable','BlogPostsController@disable')->name('disable');
        Route::post('/important','BlogPostsController@important')->name('important');
        Route::post('/no-important','BlogPostsController@noImportant')->name('no_important');
        Route::post('/delete','BlogPostsController@delete')->name('delete');
    });
    
    //Routes for SlidersController
    Route::prefix('/sliders')->name('sliders.')->group(function(){
        Route::get('/','SlidersController@index')->name('index');
        Route::post('/datatable','SlidersController@datatable')->name('datatable');
        Route::get('/create','SlidersController@create')->name('create');
        Route::post('/store','SlidersController@store')->name('store');
        Route::get('/edit/{slider}','SlidersController@edit')->name('edit');
        Route::post('/update/{slider}','SlidersController@update')->name('update');
        Route::post('/enable','SlidersController@enable')->name('enable');
        Route::post('/disable','SlidersController@disable')->name('disable');       
        Route::post('/change-priorities','SlidersController@changePriorities')->name('change_priorities');
        Route::post('/delete','SlidersController@delete')->name('delete');
    });
    
});

//Front routes

Route::name('front.')->group(function(){
    
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

Auth::routes();
