<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('tests', 'TestController')->only('index', 'store');

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
 * DoctorPatientAppointment
 */
Route::resource('doctors.patients.appointments', 'Doctor\DoctorPatientAppointmentController');

/**
 * DoctorSchedulingSlot
 */
Route::post('doctors/{doctor}/scheduling-time-slots',
    'Doctor\DoctorSchedulingTimeSlotAjaxController@store')
    ->name('doctors.scheduling.time.slots');


/**
 * Patient
 */
Route::resource('patients', 'Patient\PatientController');

/**
 * Home
 */
Route::get('/home', 'HomeController@index')->name('home');
