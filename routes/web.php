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
 * Event
 */
Route::get('/events/list', 'Event\EventAjaxController@index')
    ->name('events.list');
Route::resource('events', 'Event\EventController');

/**
 * Home
 */
Route::get('/home', 'HomeController@index')->name('home');
