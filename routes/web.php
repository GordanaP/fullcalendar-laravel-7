<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/**
 * Auth
 */
Auth::routes();

/**
 * Appointment
 */
Route::get('/appointments/list', 'Appointment\AppointmentAjaxController@index')
    ->name('appointments.list');
Route::resource('appointments', 'Appointment\AppointmentController');

/**
 * Home
 */
Route::get('/home', 'HomeController@index')->name('home');
