@extends("layout")
@section("content")
    <h2>Hello, {{{ Auth::user()->username }}}</h2>
    <p>Your profile page.</p>
    
    <a href="{{{ URL::to("/editUser/".Auth::user()->id) }}}">Edit UserData</a>
    <br>
    <a href="{{{ URL::to("/changePass") }}}">Change Password</a>
    <br><br>
    @if (Auth::user()->picture)
        <div>
            <div>profile pic</div>
            <img src="{{URL::to('/')}}/{{{Auth::user()->picture}}}" alt="user picture"/>
        </div>
    @endif
    
        @if (Auth::user()->userGroup===1)
        <p> You Have Admin Rights! </p>
        @endif
@stop