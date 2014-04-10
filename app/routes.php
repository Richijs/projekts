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


Route::group(["before" => "guest"], function()
{
    Route::any("/", [
        "as"   => "users/login",
        "uses" => "UsersController@loginAction"
    ]);
    Route::any("/request", [
        "as"   => "users/request",
        "uses" => "UsersController@requestAction"
    ]);
    Route::any("/reset", [
        "as"   => "users/reset",
        "uses" => "UsersController@resetAction"
    ]);
});
Route::group(["before" => "auth"], function()
{
    Route::any("/profile", [
        "as"   => "users/profile",
        "uses" => "UsersController@profileAction"
    ]);
    Route::any("/logout", [
        "as"   => "users/logout",
        "uses" => "UsersController@logoutAction"
    ]);
});

