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

Route::group(['middleware' => 'auth'], function() {
    Route::get('/', 'HomeController@index')->name('home');

    Route::resource('/bill', 'BillController', ['only' => ['index', 'create', 'store']]);
    
    Route::group(['middleware' => 'can:view,bill'], function() {
        Route::resource('/bill', 'BillController', ['only' => ['edit', 'update', 'destroy']]);
    });
});

Auth::routes();