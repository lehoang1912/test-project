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

    Route::get('/users', 'UserController@index')->middleware('can:viewAny,App\Models\User')->name('api.users.list');
    Route::get('/users/{user}', 'UserController@show')->middleware('can:view,user')->name('api.users.show');
    Route::post('/users', 'UserController@store')->middleware('can:create,App\Models\User')->name('api.users.store');
    Route::put('/users/{user}', 'UserController@update')->middleware('can:update,user')->name('api.users.update');
    Route::delete('/users/{user}', 'UserController@destroy')->middleware('can:delete,user')->name('api.users.delete');

    Route::get('/jobs', 'JobController@index')->name('api.jobs.list');
    Route::get('/jobs/{job}', 'JobController@show')->name('api.jobs.show');
    Route::post('/jobs', 'JobController@store')->name('api.jobs.store');
    Route::put('/jobs/{job}', 'JobController@update')->middleware('can:update,job')->name('api.jobs.update');
    Route::delete('/jobs/{job}', 'JobController@destroy')->middleware('can:delete,job')->name('api.jobs.delete');

    Route::post('/jobs/{job}/certificates', 'CertificateController@store')->middleware('can:create,App\Models\Certificate,job')->name('api.certificates.store');
    Route::delete('/jobs/{job}/certificates/{certificate}', 'CertificateController@destroy')->middleware('can:delete,certificate,job')->name('api.certificates.delete');
});
