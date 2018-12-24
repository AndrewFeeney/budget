<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Auth::routes();

Route::group(['middleware' => 'auth'], function() {
    Route::get('/', 'HomeController@index')->name('home');

    Route::resource('account', 'AccountController');
    Route::resource('journal', 'JournalController');
    Route::resource('projected-journal', 'ProjectedJournalController');
    Route::resource('projected-income', 'ProjectedIncomeController');
    Route::resource('setting', 'SettingController');
});
