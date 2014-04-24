@extends("layout")
@section("content")
    <h2>Hello, {{{ Auth::user()->username }}}</h2>
    <p>Your profile page.</p>
    
    <a href="{{{ URL::to("/editUser/".Auth::user()->id) }}}">Edit UserData</a>
    <br>
    <a href="{{{ URL::to("/changePass") }}}">Change Password</a>
    <br>
    <a href="{{{ URL::to("/deleteUser/".Auth::user()->id) }}}">Delete profile</a>
    <br>
    @if (Auth::user()->userGroup===1 || Auth::user()->userGroup===2)
        <a href="{{{ URL::to("/myVacancies") }}}">My Vacancies</a>
    @endif
    <br>
    @if (Auth::user()->userGroup===1 || Auth::user()->userGroup===3)
        <a href="{{{ URL::to("/myJobSeek") }}}">My Job Seek</a>
        <br>
        <a href="{{{ URL::to("/myApplications") }}}">My Applications</a>
    @endif
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