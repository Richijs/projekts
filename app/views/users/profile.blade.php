@extends("layout")
@section("content")

<div class="page-header">
    <h1>Hello, {{{ Auth::user()->username }}}
        <div><small>Your profile page</small></div>
    </h1>
</div>

    <a class="btn btn-warning" href="{{{ URL::to("/editUser/".Auth::user()->id) }}}">Edit UserData</a>
    <br>
    <a class="btn btn-warning" href="{{{ URL::to("/changePass") }}}">Change Password</a>
    <br>
    <a class="btn btn-danger" href="{{{ URL::to("/deleteUser/".Auth::user()->id) }}}">Delete profile</a>
    <br>
    <a class="btn btn-default" href="{{{ URL::to("/viewRecommendations/".Auth::user()->id) }}}">Users who I have recommended</a>
    <br>
    @if (Auth::user()->userGroup===1 || Auth::user()->userGroup===2)
        <a class="btn btn-default" href="{{{ URL::to("/viewRecommenders/".Auth::user()->id) }}}">Users who recommended me</a>
        <br>
        <a class="btn btn-default" href="{{{ URL::to("/myVacancies") }}}">My Vacancies</a>
    @endif
    <br>
    @if (Auth::user()->userGroup===1 || Auth::user()->userGroup===3)
        <a class="btn btn-default" href="{{{ URL::to("/myJobSeek") }}}">My Job Seek</a>
        <br>
        <a class="btn btn-default" href="{{{ URL::to("/myApplications") }}}">My Applications</a>
    @endif
    <br><br>
    
    @if (Auth::user()->picture)
        <div>
            <img src="{{URL::to('/')}}/{{{Auth::user()->picture}}}" width="200" alt="user picture"/>
        </div>
    @else
        <div>
             <img src="{{URL::to('/')}}/uploads/profileImages/default.jpeg" width="200" alt="profile picture"/>
        </div>
    @endif
    
        @if (Auth::user()->userGroup===1)
        <p> You Have Admin Rights! </p>
        @endif
@stop