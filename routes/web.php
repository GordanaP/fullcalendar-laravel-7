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
 * DoctorAppointment
 */
Route::get('doctors/{doctor}/appointments/list', 'Doctor\DoctorAppointmentAjaxController@index')
    ->name('doctors.appointments.list');
Route::resource('doctors.appointments', 'Doctor\DoctorAppointmentController');


/**
 * Home
 */
Route::get('/home', 'HomeController@index')->name('home');
