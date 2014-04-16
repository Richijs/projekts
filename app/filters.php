<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
    if ( in_array(Request::segment(1), Config::get('app.languages')) ) {
        Session::put('locale', Request::segment(1));
        return Redirect::to(substr(Request::path(), 3));
    }
        
    //pirms ielogošanās uzliek preferred lang
    if (isset(Auth::user()->prefLang)){
         Session::put('locale', Auth::user()->prefLang);
    }
    
    if ( Session::has('locale') ) {
        App::setLocale(Session::get('locale'));
    }
    
	/*if( !Request::secure())
        {
            return Redirect::secure(Request::getRequestUri());
        }*/
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest()) 
        {
            Session::flash('message-fail','No access to action');
            return Redirect::route('users/login'); //return Redirect::guest('users/login'); same?
        }
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) {
            Session::flash('message-fail','Must log out first');
        return Redirect::route('users/profile'); //return Redirect::to('users/profile'); ?
        }
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

//csrf attack protection filter , every POST request must be filtered
Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});

//Nekorektas saites gadījumā pārvirza uz 404 lapu
App::missing(function($exception)
{
    return Response::view('errors.404', array(), 404);
});