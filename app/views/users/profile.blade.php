@extends("layout")
@section("content")
    <h2>Hello, {{{ Auth::user()->username }}}</h2>
    <p>Your profile page.</p>
    
    <a href="{{{ URL::to("/editUser/".Auth::user()->id) }}}">Edit UserData</a>
    <br>
    <a href="{{{ URL::to("/changePass") }}}">Change Password</a>
        @if (Auth::user()->userGroup===1)
        <p> You Have Admin Rights! </p>
        @endif
@stop