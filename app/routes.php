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

//uzst�da noklus�juma skatu
Route::get('/', function()
{
	return View::make('index');
});

//p�rvirza uz s�kumu, nekorektas saites gad�jum�
Route::get('/{anything}', function()
{
	return Response::view('errors.404');
});