<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/', array('as' => 'home', 'uses' => 'HomeController@index'));
Route::get('doctor', array('as' => 'read_doctors', 'uses' => 'HomeController@show'));
Route::get('doctor/{id}', array('as' => 'read_doctor', 'uses' => 'HomeController@get'));
Route::get('doctor/{id}/appointment', array('as' => 'read_doctor_appointments', 'uses' => 'HomeController@getAppointments'));
