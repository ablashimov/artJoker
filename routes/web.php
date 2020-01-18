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

Route::get('/', 'HomeController@index')->name('home');
Route::group(['prefix' => 'students', 'as' => 'students.'], function () {
    Route::get('/', 'StudentController@index')->name('index');

    Route::group(['prefix' => 'export'], function () {
        Route::post('/', 'ExportController@exportStudentsToCSV')->name('export');
        Route::get('/register-all-courses', 'ExportController@exportCourseAttendanceToCSV')->name('export-register-all-courses');
    });
});

