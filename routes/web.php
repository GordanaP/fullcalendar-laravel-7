<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

/**
 * Event
 */
Route::get('/events/list', 'Event\EventAjaxController@index')
    ->name('events.list');


Route::get('/home', 'HomeController@index')->name('home');
