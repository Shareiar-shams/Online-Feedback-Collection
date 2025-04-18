<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::group(['namespace'=> 'App\Http\Controllers\User', ],function(){

    Route::get('/', 'ViewportController@index')->name('main');
    Route::get('/check', 'ViewportController@create')->name('create');
    Route::post('/dynamic/forms/submission', 'ViewportController@store')->name('dynamic.submit');
    Route::get('/test', 'ViewportController@test')->name('test');
 

});

Route::group(['namespace'=> 'App\Http\Controllers\Admin'],function(){
    Route::middleware('auth')->group(function(){
        //Admin Dashboard
        Route::get('/admin/dashboard', 'HomeController@index')->name('dashboard');

        // Chart report route

        Route::get('/admin/get-today-feedback-count', 'HomeController@getTodayFeedbackCount')->name('getTodayFeedbackCount');

        Route::get('/admin/get-this-month-feedback-count', 'HomeController@getThisMonthFeedbackCount')->name('getThisMonthFeedbackCount');

        // Course Route
        Route::resource('/admin/course', 'CourseController');
        Route::delete('module/delete/{id}','CourseController@moduleDelete')->name('moduleDelete');
        Route::delete('module/content/delete/{id}','CourseController@contentDelete')->name('contentDelete');
        //Form Showing route
        Route::get('/admin/show/form', 'HomeController@show_forms')->name('show_forms');

        //Form Create Route
        Route::get('/admin/create/form', 'HomeController@create')->name('form.create');
        Route::post('admin/create/form', 'HomeController@store')->name('create_from');

        // Form Route
        Route::resource('admin/form','HomeController');
        Route::put('/admin/form/status/{id}','HomeController@status')->name('form.status');

        //Submitted Form List
        Route::get('/admin/submitted/feedback/list', 'HomeController@submitted_form_list')->name('submitted_form_list');
        Route::delete('/admin/submitted/feedback/delete/{id}', 'HomeController@submitted_form_delete')->name('submitted_form_delete');

        // Admin Profile
        Route::get('/admin/profile', 'HomeController@profile')->name('admin.profile');
        Route::post('/admin/image/update/{id}', 'HomeController@imgupdate')->name('admin.image.update');
        Route::put('/admin/password/update/{id}', 'HomeController@passupdate')->name('admin.password.update');
        Route::put('/admin/profile/update/{id}', 'HomeController@update')->name('admin.profile.update');

    });
    
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
