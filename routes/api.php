<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/profile', 'ProfileController@show')->name('api.profile.get');

    Route::get('/jobs', 'JobController@index')->name('api.jobs.list');
    Route::get('/jobs/{job}', 'JobController@show')->name('api.jobs.show');
    Route::post('/jobs', 'JobController@store')->name('api.jobs.store');
    Route::put('/jobs/{job}', 'JobController@update')->name('api.jobs.update');
    Route::delete('/jobs/{job}', 'JobController@destroy')->name('api.jobs.delete');

    Route::post('/jobs/{job}/certificates', 'CertificateController@store')->name('api.certificates.store');
    Route::delete('/jobs/{job}/certificates/{certificate}', 'CertificateController@destroy')->name('api.certificates.delete');
});
