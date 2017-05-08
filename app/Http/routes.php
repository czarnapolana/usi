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
Route::post('/doctor/create', array('as' => 'doctor.create', 'uses' => 'DoctorController@create'));
Route::post('/doctor/{doctor_id}/edit', array('as' => 'doctor.edit', 'uses' => 'DoctorController@edit'));
Route::delete('/doctor/{doctor_id}/delete', array('as' => 'doctor.delete', 'uses' => 'DoctorController@delete'));
Route::get('/doctor/{doctor_id}', array('as' => 'doctor.get', 'uses' => 'DoctorController@read'));
Route::get('/doctor/{doctor_id}/appointment', array('as' => 'doctor_appointments.get', 'uses' => 'DoctorController@getAppointments'));
Route::get('/doctor/{doctor_id}/appointment/{appointment_id}', array('as' => 'doctor_appointment.get', 'uses' => 'DoctorController@getAppointment'));
Route::post('/doctor/{doctor_id}/appointment', array('as' => 'doctor_appointment_by_date.get', 'uses' => 'DoctorController@getAppointmentByDate'));
Route::get('/doctor', array('as' => 'doctors.get', 'uses' => 'DoctorController@getDoctors'));
Route::get('/doctor/speciality/{speciality_id}', array('as' => 'doctors_by_speciality.get', 'uses' => 'DoctorController@getDoctorsBySpeciality'));
Route::post('/patient/create', array('as' => 'patient.create', 'uses' => 'PatientController@create'));
Route::post('/patient/{patient_id}/edit', array('as' => 'patient.edit', 'uses' => 'PatientController@edit'));
Route::delete('/patient/{patient_id}/delete', array('as' => 'patient.delete', 'uses' => 'PatientController@delete'));
Route::get('/patient/{patient_id}', array('as' => 'patient.get', 'uses' => 'PatientController@read'));
Route::get('/patient/{patient_id}/appointment', array('as' => 'patient_appointments.get', 'uses' => 'PatientController@getAppointments'));
Route::get('/patient/{patient_id}/appointment/{appointment_id}', array('as' => 'patient_appointment.get', 'uses' => 'PatientController@getAppointment'));
Route::post('/patient/{patient_id}/appointment', array('as' => 'patient_appointment_by_date.get', 'uses' => 'PatientController@getAppointmentByDate'));
Route::post('/patient/{patient_id}/appointment/speciality', array('as' => 'patient_appointment_by_speciality.get', 'uses' => 'PatientController@getAppointmentBySpeciality'));
Route::get('/patient', array('as' => 'patients.get', 'uses' => 'PatientController@getPatients'));
Route::post('/appointment/create', array('as' => 'appointment.create', 'uses' => 'AppointmentController@create'));
Route::post('/appointment/{appointment_id}/edit', array('as' => 'appointment.edit', 'uses' => 'AppointmentController@edit'));
Route::delete('/appointment/{appointment_id}/delete', array('as' => 'appointment.delete', 'uses' => 'AppointmentController@delete'));
Route::get('/appointment/{appointment_id}', array('as' => 'appointment.get', 'uses' => 'AppointmentController@read'));
Route::get('/appointment', array('as' => 'appointments.get', 'uses' => 'AppointmentController@getAppointments'));
Route::post('/speciality/{speciality_id}/edit', array('as' => 'speciality.edit', 'uses' => 'SpecialityController@edit'));
Route::get('/speciality/{speciality_id}', array('as' => 'speciality.get', 'uses' => 'SpecialityController@read'));
Route::get('/speciality', array('as' => 'specialities.get', 'uses' => 'SpecialityController@getSpecialities'));

