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

//uzstвda noklusзjuma skatu
Route::get('/', function()
{
	return View::make('index');
});

Route::get('user/{id}','UsersController@viewProfile');

//pвrvirza uz sвkumu, nekorektas saites gadоjumв
// !!!SVARОGI: Vienmзr jвatrodas paрвs beigвs, lai nepвrrakstоtu pвrзjos routes
Route::get('/{incorrect}', function()
{
	return Response::view('errors.404');
});

