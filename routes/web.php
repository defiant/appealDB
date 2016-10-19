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
Auth::routes();

Route::get('/documentation', function(){
    return view('documentation');
});

Route::get('/create', ['middleware' => 'auth', 'uses' => 'HomeController@create']);
Route::post('/store', ['middleware' => 'auth', 'uses' => 'HomeController@store']);

Route::get('/{id}', 'HomeController@show');
Route::get('/', 'HomeController@index');

