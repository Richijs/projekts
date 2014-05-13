@extends("layout")
@section("content")

    <div class="page-header">
        <h1>
            Hello, {{{'/' /*Auth::user()->username*/ }}}
            <small>You're now registered</small>
        </h1>
    </div>
   
    <a href="{{{ URL::to("/") }}}">Check home page</a>
    <br><br><br>
    Other stuff:
    <br>
    <a href="{{{ '/'/*URL::to("/editUser/".Auth::user()->id)*/ }}}">Edit UserData</a>
    <br>
    <a href="{{{ URL::to("/changePass") }}}">Change Password</a>
    
@stop