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

Route::get('user/{id}','UsersController@viewProfile');

//p�rvirza uz s�kumu, nekorektas saites gad�jum�
// !!!SVAR�GI: Vienm�r j�atrodas pa��s beig�s, lai nep�rrakst�tu p�r�jos routes
Route::get('/{incorrect}', function()
{
	return Response::view('errors.404');
});

