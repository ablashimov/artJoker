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
Route::get('', 'HomeController@index')->name('home');
Route::group(['prefix' => 'students', 'as' => 'students.'], function () {
    Route::get('/', 'StudentController@index')->name('index');
});
Route::get('export', ['uses' => 'ExportController@export', 'as' => 'export']);