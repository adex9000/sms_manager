<?php

// Shared view data
View::share('user', Auth::user());
View::share('active_menu_item', '');
View::share('active_menu_item_dropdown', '');

// Custom Validation Rules
Validator::extend('destinationnos', 'Binghamuni\Forms\SmsForm@validateDestinationnos');
Validator::extend('gsm', 'Binghamuni\Forms\StaffForm@validateGsm');

// Home
Route::get('/', [
    'as' => 'home',
    'uses' => 'HomeController@index'
]);

// Users
Route::group(['prefix' => 'users'], function(){

    Route::post('signin', [
        'as' => 'signin',
        'uses' => 'UsersController@signin'
    ]);

    Route::get('dashboard', [
        'as' => 'dashboard',
        'uses' => 'UsersController@dashboard'
    ]);

    Route::get('sms', [
        'as' => 'new_sms',
        'uses' => 'UsersController@new_sms'
    ]);

    Route::get('edit_sms/{id}', [
        'as' => 'edit_sms',
        'uses' => 'UsersController@edit_sms'
    ]);

    Route::get('s/{id}', [
        'as' => 'ss',
        'uses' => 'UsersController@ss'
    ]);

    Route::post('send_sms', [
        'before' => 'csrf',
        'as' => 'send_sms',
        'uses' => 'UsersController@send_sms'
    ]);

    Route::get('logout', [
    'as' => 'logout',
    'uses' => 'UsersController@logout'
    ]);

});

// Students
Route::group(['prefix' => 'students', 'before' => 'auth'],function(){

    // Search - GET
    Route::get('search', [
        'as' => 'search_students',
        'uses' => 'StudentsController@search_students'
    ]);

    Route::get('departments', [
        'as' => 'search_departments',
        'uses' => 'StudentsController@search_departments'
    ]);

    Route::get('states', [
        'as' => 'search_states',
        'uses' => 'StudentsController@search_states'
    ]);

    Route::get('gender', [
        'as' => 'search_genders',
        'uses' => 'StudentsController@search_genders'
    ]);

    // Search - POST
    Route::post('search', [
        'before' => 'csrf',
        'as' => 'student_search',
        'uses' => 'StudentsController@student_search'
    ]);

    Route::post('departments', [
        'before' => 'csrf',
        'as' => 'search_department',
        'uses' => 'StudentsController@department_search'
    ]);

    Route::post('states', [
        'before' => 'csrf',
        'as' => 'search_state',
        'uses' => 'StudentsController@state_search'
    ]);

    Route::post('gender', [
        'before' => 'csrf',
        'as' => 'search_gender',
        'uses' => 'StudentsController@gender_search'
    ]);

    Route::post('csv', [
        'before' => 'csrf',
        'as' => 'csv',
        'uses' => 'StudentsController@export_csv'
    ]);


});

// Staff
Route::group(['prefix' => 'staff', 'before' => 'auth'],function(){

    // GET - Staff SMS
    Route::get('new_staff', [
        'as' => 'new_staff',
        'uses' => 'StaffController@new_staff'
    ]);

    Route::get('search_staff',[
        'as' => 'search_staff',
        'uses' => 'StaffController@search_staff'
    ]);

    Route::get('sms/{id}',[
        'as' => 'sms_send',
        'uses' => 'StaffController@sms_send'
    ]);

    Route::get('edit/{id}',[
        'as' => 'edit_staff',
        'uses' => 'StaffController@edit_staff'
    ]);

    // POST - Staff SMS
    Route::post('new_staff', [
        'before' => 'csrf',
        'as' => 'new_staff_member',
        'uses' => 'StaffController@new_staff_member'
    ]);

    Route::post('edit_staff', [
        'before' => 'csrf',
        'as' => 'edit_staff_member',
        'uses' => 'StaffController@edit_staff_member'
    ]);

    Route::post('search_staff',[
        'before' => 'csrf',
        'as' => 'staff_search',
        'uses' => 'StaffController@staff_search'
    ]);

    Route::get('sms/{id}',[
        'as' => 'sms_send',
        'uses' => 'StaffController@sms_send'
    ]);


});

Route::group(['prefix' => 'sms'], function(){

    // SMS Details
    Route::post('sms_send', [
        'before' => 'csrf',
        'as' => 'send_sms_message',
        'uses' => 'SmsController@send_sms'
    ]);

});