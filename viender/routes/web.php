<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::group(['domain' => config('app.api_domain')], function() {
	Route::get('/', 'HomeController@index');
});

Route::get('/sw.js', 'ServiceWorkerController@index');
