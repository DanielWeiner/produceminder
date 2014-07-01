<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::get('product', function(){
	return View::make('product');
});
Route::get('/view/login', function(){
	return View::make('login');
});
Route::get('user', 'ApiController@getUserFromApiToken');
Route::get('user/{id}/delete','ApiController@deleteUser');
Route::get('user/{id}/delete','ApiController@deleteUser');
Route::get('/user/create/', 'ApiController@createUser');
Route::get('/user/{id}', 'ApiController@getUser');
Route::get('/','HomeController@goHome');
