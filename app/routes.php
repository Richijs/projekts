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
Route::any("/", [
    "as"   => "home",
    "uses" => "HomeController@viewHome"
]);

/*Route::any("/lang/{lang}", [
    "as"   => "empty",
    "uses" => "LangController@changeLang"
]);*/ //izrādās šis nav vajadzīgs
Route::get('/lang/{lang}', 'LangController@changeLang')->where('lang','lv|en'); //divas pieejamas valodas

Route::any("/viewUser/{id}", [
    "as"   => "users/view/{id}",
    "uses" => "UsersController@viewAction"
])
->where('id','[0-9]+');

Route::any("/viewAllUsers", [
    "as"   => "users/viewAllUsers",
    "uses" => "UsersController@viewAllAction"
]);

Route::group(["before" => "guest"], function()
{
    Route::any("/login",[ 
        "as"   => "users/login",
        "uses" => "UsersController@loginAction"
    ]);
    Route::any("/register", [
        "as"   => "users/register",
        "uses" => "UsersController@registerAction"
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
    Route::any("/editUser/{id}", [
        "as"   => "users/edit",
        "uses" => "UsersController@editAction"
    ])->where('id','[0-9]+');
        
    Route::any("/profile", [
        "as"   => "users/profile",
        "uses" => "UsersController@profileAction"
    ]);
    
    Route::any("/changePass", [
        "as"   => "users/changePass",
        "uses" => "UsersController@changePassAction"
    ]);
    
    Route::any("/logout", [
        "as"   => "users/logout",
        "uses" => "UsersController@logoutAction"
    ]);
});

