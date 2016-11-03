<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
	Route::get('/home', 'HomeController@index');
	Route::get('/sets','SetsController@getIndex');
	Route::get('/sets/create','SetsController@getCreate');
	Route::post('/sets/create','SetsController@postCreate');
	Route::get('/sets/view/{id}','SetsController@getView');
	Route::get('/sets/edit/{id}','SetsController@getEdit');
	Route::post('/sets/edit/{id}','SetsController@postEdit');
	Route::get('/sets/delete/{id}','SetsController@getDelete');
	Route::post('/sets/add-camera','SetsController@postAddcamera');
	Route::post('/sets/edit-camera/{id}','SetsController@postEditcamera');
	Route::post('/sets/delete-camera/{id}','SetsController@postDeleteCamera');
});
