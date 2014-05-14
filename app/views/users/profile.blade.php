@extends("layout")
@section("content")

<div class="page-header">
    <h1>Hello, <a href="{{{ URL::to("/viewUser/".Auth::user()->id) }}}">{{{ Auth::user()->username }}}</a>
        <div><small>Your profile page</small></div>
    </h1>
</div>



<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">
            <b>Profile panel</b>
        </div>
    </div>
    <div class="panel-body">
        

                        
            <div class="btn-group-vertical col-sm-5">

    <a class="btn btn-warning" href="{{{ URL::to("/editUser/".Auth::user()->id) }}}">Edit User Data</a>            
                
    <a class="btn btn-warning" href="{{{ URL::to("/changePass") }}}">Change Password</a>

    <a class="btn btn-danger" href="{{{ URL::to("/deleteUser/".Auth::user()->id) }}}">Delete profile</a>

    <a class="btn btn-default" href="{{{ URL::to("/viewRecommendations/".Auth::user()->id) }}}">Users who I have recommended</a>

    @if (Auth::user()->userGroup===1 || Auth::user()->userGroup===2)
        <a class="btn btn-default" href="{{{ URL::to("/viewRecommenders/".Auth::user()->id) }}}">Users who recommended me</a>

        <a class="btn btn-default" href="{{{ URL::to("/myVacancies") }}}">My Vacancies</a>
    @endif

    @if (Auth::user()->userGroup===1 || Auth::user()->userGroup===3)
        <a class="btn btn-default" href="{{{ URL::to("/myJobSeek") }}}">My Job Seek</a>

        <a class="btn btn-default" href="{{{ URL::to("/myApplications") }}}">My Applications</a>
    @endif
    
    <div class="pull-right">
    <b>Profile picture:</b>
            @if (Auth::user()->picture)
            
                <img class="img-thumbnail" src="{{URL::to('/')}}/{{{Auth::user()->picture}}}" width="200" alt="user picture"/>
            
            @else
            
                <img class="img-thumbnail" src="{{URL::to('/')}}/uploads/profileImages/default.jpeg" width="200" alt="profile picture"/>
            
        @endif

        </div>
            </div>   
            

                   
              <ul class="list-group col-sm-offset-0 col-sm-5">
          
                  
        <li class="list-group-item">
            <b>Username:</b> {{{Auth::user()->username}}}
        </li>
        <li class="list-group-item">
            <b>First name:</b> {{{Auth::user()->firstname}}}
        </li>
        <li class="list-group-item">
            <b>Last name:</b> {{{Auth::user()->lastname}}}
        </li>
        <li class="list-group-item">
            <b>E-mail:</b> {{{Auth::user()->email}}}
        </li>
        
        @if (Auth::user()->about)
        <li class="list-group-item">
        <b>About:</b>
        <div class="newlineText well well-sm">{{{Auth::user()->about}}}</div>
        @endif
        </li>
        
        <li class="list-group-item">
            <b>User Group:</b>
            @if (Auth::user()->userGroup===1) Admin @endif
            @if (Auth::user()->userGroup===2) Employer @endif
            @if (Auth::user()->userGroup===3) Job Searcher @endif
        </li>
        <li class="list-group-item">
            <b>Joined:</b> {{{Auth::user()->created_at}}}
        </li>
              </ul>
                 </div>
    
</div>


@stop