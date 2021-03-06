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
    //globālie post route
    
    Route::post("/contactAdmin", [
        "as"   => "messaging/contact",
        "uses" => "MessagingController@contactAction"
    ]);  
    
    Route::post("/search", [
        "as"   => "/search",
        "uses" => "HomeController@searchAction"
    ]);
    
});

    //lai varētu veikt veiksmīgu pārvirzi, mainot valodu pēc meklēšanas
    Route::get("/search", [
        "as"   => "/search",
        "uses" => "HomeController@searchAction"
    ]);

    Route::get("/contactAdmin", [
        "as"   => "messaging/contact",
        "uses" => "MessagingController@contactAction"
    ]);

    Route::get("/", [
        "as"   => "home",
        "uses" => "HomeController@viewHome"
    ]);

    Route::get('/lang/{lang}', 'LangController@changeLang')->where('lang','lv|en'); //divas pieejamas valodas

    Route::get("/viewVacancie/{id}", [
        "as"   => "vacancies/view/{id}",
        "uses" => "VacanciesController@viewAction"
    ])->where('id','[0-9]+');
    
    Route::get("/viewAllVacancies", [
        "as"   => "vacancies/viewAllVacancies",
        "uses" => "VacanciesController@viewAllAction"
    ]);
    
    Route::get("/about", [
        "as"   => "/about",
        "uses" => "HomeController@viewAbout"
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
        
        Route::post("/sendMessage/{receiver_id}", [
            "as"   => "messaging/send",
            "uses" => "MessagingController@sendAction"
        ])->where('receiver_id','[0-9]+');
        
    });
    
    Route::get("/viewRecommenders/{userId}", [
        "as"   => "recommendations/viewRecommenders",
        "uses" => "RecommendationsController@viewRecommendersAction"
    ])->where('id','[0-9]+');
    
    Route::get("/viewRecommendations/{userId}", [
        "as"   => "recommendations/viewRecommendations",
        "uses" => "RecommendationsController@viewRecommendationsAction"
    ])->where('id','[0-9]+');
    
    Route::get("/viewAllUsers", [
        "as"   => "users/viewAllUsers",
        "uses" => "UsersController@viewAllAction"
    ]);
    
    Route::get("/viewUser/{id}", [
        "as"   => "users/view/{id}",
        "uses" => "UsersController@viewAction"
    ])->where('id','[0-9]+');
    
    Route::get("/sendMessage/{receiver_id}", [
        "as"   => "messaging/send",
        "uses" => "MessagingController@sendAction"
    ])->where('receiver_id','[0-9]+');
    
    Route::get("/viewMessages/{user_id}", [
        "as"   => "messaging/viewMessages",
        "uses" => "MessagingController@viewMessagesAction"
    ])->where('user_id','[0-9]+');
    
    Route::get("/viewMessage/{message_id}", [
        "as"   => "messaging/viewMessage",
        "uses" => "MessagingController@viewMessageAction"
    ])->where('message_id','[0-9]+');
        
    Route::get("/viewSeeker/{id}", [
        "as"   => "seekers/view/{id}",
        "uses" => "SeekersController@viewAction"
    ])->where('id','[0-9]+');
     
    Route::get('/getCV/{id}', 'SeekersController@getCVAction')->where('id','[0-9]+'); //DL cv
    
    Route::get('/recommend/{employerId}', 'RecommendationsController@recommendAction')->where('id','[0-9]+');    
        
    Route::get("/viewApplication/{applicationId}", [
        "as"   => "applications/view",
        "uses" => "ApplicationsController@viewAction"
    ])->where('id','[0-9]+');
    
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
        
        Route::post("/deleteVacancie/{id}", [
            "as"   => "vacancies/delete",
            "uses" => "VacanciesController@deleteAction"
        ])->where('id','[0-9]+');
        
    });
    
    
    Route::get("/viewAllSeekers", [
        "as"   => "seekers/viewAllSeekers",
        "uses" => "SeekersController@viewAllAction"
    ]);
    
    Route::get("/deleteVacancie/{id}", [
        "as"   => "vacancies/delete",
        "uses" => "VacanciesController@deleteAction"
    ])->where('id','[0-9]+');
    
    Route::get("/editVacancie/{id}", [
        "as"   => "vacancies/edit",
        "uses" => "VacanciesController@editAction"
    ])->where('id','[0-9]+');    
    
    
    Route::get("/viewApplicants/{vacancieId}", [
        "as"   => "applications/viewApplicants",
        "uses" => "ApplicationsController@viewApplicantsAction"
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

//seeker/admin only actions
Route::group(["before" => "seeker"], function()
{
    //aizsargāts no csrf(xsrf?) uzbrukumiem
    Route::group(["before" => "csrf"], function(){
        
        Route::post("/addJobSearch", [
            "as"   => "seekers/add",
            "uses" => "SeekersController@AddAction"
        ]);
       
        Route::post("/editJobSeek/{id}", [
            "as"   => "seekers/edit",
            "uses" => "SeekersController@editAction"
        ])->where('id','[0-9]+');
        
        Route::post("/deleteJobSeek/{id}", [
            "as"   => "seekers/delete",
            "uses" => "SeekersController@deleteAction"
        ])->where('id','[0-9]+');
        
        Route::post("/apply/{vacancieId}", [
            "as"   => "applications/apply",
            "uses" => "ApplicationsController@applyAction"
        ])->where('vacancieId','[0-9]+');
        
        Route::post("/deleteApplication/{applicationId}", [
            "as"   => "applications/delete",
            "uses" => "ApplicationsController@deleteAction"
        ])->where('id','[0-9]+');
        
        Route::post("/editApplication/{applicationId}", [
            "as"   => "applications/edit",
            "uses" => "ApplicationsController@editAction"
        ])->where('id','[0-9]+');  
        
    });
    
    Route::get("/editApplication/{applicationId}", [
        "as"   => "applications/edit",
        "uses" => "ApplicationsController@editAction"
    ])->where('id','[0-9]+');    
    
    Route::get("/deleteApplication/{applicationId}", [
        "as"   => "applications/delete",
        "uses" => "ApplicationsController@deleteAction"
    ])->where('id','[0-9]+');    
    
    Route::get("/apply/{vacancieId}", [
        "as"   => "applications/apply",
        "uses" => "ApplicationsController@applyAction"
    ])->where('vacancieId','[0-9]+');
    
    Route::get("/deleteJobSeek/{id}", [
        "as"   => "seekers/delete",
        "uses" => "SeekersController@deleteAction"
    ])->where('id','[0-9]+');
    
    Route::get("/editJobSeek/{id}", [
        "as"   => "seekers/edit",
        "uses" => "SeekersController@editAction"
    ])->where('id','[0-9]+');
    
    Route::get("/myJobSeek", [
        "as"   => "seekers/viewMy",
        "uses" => "SeekersController@viewMyAction"
    ]);
    
    Route::get("/myApplications", [
        "as"   => "applications/viewMy",
        "uses" => "ApplicationsController@viewMyAction"
    ]);
    
    Route::get("/addJobSearch", [
        "as"   => "seekers/add",
        "uses" => "SeekersController@AddAction"
    ]);
    
});


//admin ONLY actions
Route::group(["before" => "admin"], function()
{
    //aizsargāts no csrf(xsrf?) uzbrukumiem
    Route::group(["before" => "csrf"], function(){
    
        //nav
    });
    
    Route::get("/deleteMessage/{message_id}", [
        "as"   => "messaging/delete",
        "uses" => "MessagingController@deleteAction"
    ])->where('message_id','[0-9]+');

    
});