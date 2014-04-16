@extends("layout")
@section("content")
    <h2>Hello, {{{'/' /*Auth::user()->username*/ }}}</h2>
    <p>Registered successfully.</p>
   
    <a href="{{{ URL::to("/") }}}">Check home page</a>
    <br><br><br>
    Other stuff:
    <br>
    <a href="{{{ '/'/*URL::to("/editUser/".Auth::user()->id)*/ }}}">Edit UserData</a>
    <br>
    <a href="{{{ URL::to("/changePass") }}}">Change Password</a>
    
@stop