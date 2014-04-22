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

//VISI GET UN POST VIENMĒR JĀATDALA, POST IELIEKOT IEKŠ ATTIECĪGĀ(global/guest/auth) CSRF SECURE FILTRA

//global actions

//aizsargāts no csrf(xsrf?) uzbrukumiem
Route::group(["before" => "csrf"], function(){
    
    //pagaidām nav neviena globālā POST route
});

    Route::get("/", [
        "as"   => "home",
        "uses" => "HomeController@viewHome"
    ]);

    Route::get('/lang/{lang}', 'LangController@changeLang')->where('lang','lv|en'); //divas pieejamas valodas

    Route::get("/viewUser/{id}", [
        "as"   => "users/view/{id}",
        "uses" => "UsersController@viewAction"
    ])->where('id','[0-9]+');
    
    Route::get("/viewVacancie/{id}", [
        "as"   => "vacancies/view/{id}",
        "uses" => "VacanciesController@viewAction"
    ])->where('id','[0-9]+');

    Route::get("/viewAllUsers", [
        "as"   => "users/viewAllUsers",
        "uses" => "UsersController@viewAllAction"
    ]);
    
    Route::get("/viewAllVacancies", [
        "as"   => "vacancies/viewAllVacancies",
        "uses" => "VacanciesController@viewAllAction"
    ]);

    
//guest only actions
Route::group(["before" => "guest"], function()
{
    //aizsargāts no csrf(xsrf?) uzbrukumiem
    Route::group(["before" => "csrf"], function(){
        
        Route::post("/login",[ 
            "as"   => "users/login",
            "uses" => "UsersController@loginAction"
        ]);
        
        Route::post("/register", [
            "as"   => "users/register",
            "uses" => "UsersController@registerAction"
        ]);
        
        Route::post("/request", [
            "as"   => "users/request",
            "uses" => "UsersController@requestAction"
        ]);
        
        Route::post("/reset", [
            "as"   => "users/reset",
            "uses" => "UsersController@resetAction"
        ]);
        
        
    });
    
    Route::get("/login",[ 
        "as"   => "users/login",
        "uses" => "UsersController@loginAction"
    ]);
    
    Route::get("/register", [
        "as"   => "users/register",
        "uses" => "UsersController@registerAction"
    ]);
    
    Route::get("/request", [
        "as"   => "users/request",
        "uses" => "UsersController@requestAction"
    ]);
    
    Route::get("/reset", [
        "as"   => "users/reset",
        "uses" => "UsersController@resetAction"
    ]);    
    
    Route::get('/activate', 'UsersController@activateAction');
    
});

//authorized user only actions
Route::group(["before" => "auth"], function()
{
    //aizsargāts no csrf(xsrf?) uzbrukumiem
    Route::group(["before" => "csrf"], function(){
        
        Route::post("/editUser/{id}", [
            "as"   => "users/edit",
            "uses" => "UsersController@editAction"
        ])->where('id','[0-9]+');
        
       Route::post("/deleteUser/{id}", [
            "as"   => "users/delete",
            "uses" => "UsersController@deleteAction"
        ])->where('id','[0-9]+');
        
        Route::post("/changePass", [
            "as"   => "users/changePass",
            "uses" => "UsersController@changePassAction"
        ]);
        
    });
    
    
    Route::get("/deleteUser/{id}", [
        "as"   => "users/delete",
        "uses" => "UsersController@deleteAction"
    ])->where('id','[0-9]+');
    
    Route::get("/editUser/{id}", [
        "as"   => "users/edit",
        "uses" => "UsersController@editAction"
    ])->where('id','[0-9]+');
        
    Route::get("/profile", [
        "as"   => "users/profile",
        "uses" => "UsersController@profileAction"
    ]);
    
    Route::get("/changePass", [
        "as"   => "users/changePass",
        "uses" => "UsersController@changePassAction"
    ]);
    
    Route::get("/logout", [
        "as"   => "users/logout",
        "uses" => "UsersController@logoutAction"
    ]);
    
});

//employer/admin only actions
Route::group(["before" => "employer"], function()
{
    //aizsargāts no csrf(xsrf?) uzbrukumiem
    Route::group(["before" => "csrf"], function(){
        
        Route::post("/addVacancie", [
            "as"   => "vacancies/add",
            "uses" => "VacanciesController@AddAction"
        ]);
        
        Route::post("/editVacancie/{id}", [
            "as"   => "vacancies/edit",
            "uses" => "VacanciesController@editAction"
        ])->where('id','[0-9]+');
        
    });
    
    
    Route::get("/editVacancie/{id}", [
        "as"   => "vacancies/edit",
        "uses" => "VacanciesController@editAction"
    ])->where('id','[0-9]+');    
    
    Route::get("/myVacancies", [
        "as"   => "vacancies/myVacancies",
        "uses" => "vacanciesController@MyVacanciesAction"
    ]);
    
    Route::get("/addVacancie", [
        "as"   => "vacancies/add",
        "uses" => "VacanciesController@AddAction"
    ]);
    
});