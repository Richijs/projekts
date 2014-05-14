@extends("layout")
@section("content")

<div class="page-header">
    <h1>
        Viewing: <a href="{{ URL::to("/viewUser/".$user->id) }}">{{{ $user->username }}}</a> 
        <small>Public profile</small>
    </h1>
</div>
    
    <div class="panel panel-primary">
    <div class="panel-heading">
        <div class="panel-title">
            <b>Data</b>
        </div>
    </div>
    <div class="panel-body">
        

                        
            <div class="btn-group-vertical col-sm-5">

    <a class="btn btn-warning" href="{{{ URL::to("/editUser/".$user->id) }}}">Edit User Data</a>            
                
    @if (Auth::user()->id == $user->id)
    
    @endif
    
    <a class="btn btn-danger" href="{{{ URL::to("/deleteUser/".$user->id) }}}">Delete profile</a>

    <a class="btn btn-default" href="{{{ URL::to("/viewRecommendations/".$user->id) }}}">Users who this user has recommended</a>

    @if (Auth::user()->userGroup===1 || Auth::user()->userGroup===2)
        <a class="btn btn-default" href="{{{ URL::to("/viewRecommenders/".$user->id) }}}">Users who recommended this user</a>

    @endif

    @if (Auth::user()->userGroup===1 || Auth::user()->userGroup===3)
        <a class="btn btn-default" href="{{{ URL::to("/viewSeeker/"."šeit būs seeker id!!!!!") }}}">view Job Seek data</a>

    @endif
    
    <div class="pull-right">
    <b>Profile picture:</b>
            @if (Auth::user()->picture)
            
                <img class="img-thumbnail" src="{{URL::to('/')}}/{{{$user->picture}}}" width="200" alt="user picture"/>
            
            @else
            
                <img class="img-thumbnail" src="{{URL::to('/')}}/uploads/profileImages/default.jpeg" width="200" alt="profile picture"/>
            
        @endif

        </div>
            </div>   
            

                   
              <ul class="list-group col-sm-5">
          
                  
        <li class="list-group-item">
            <b>Username:</b> {{{$user->username}}}
        </li>
        <li class="list-group-item">
            <b>First name:</b> {{{$user->firstname}}}
        </li>
        <li class="list-group-item">
            <b>Last name:</b> {{{$user->lastname}}}
        </li>
        <li class="list-group-item">
            <b>E-mail:</b> {{{$user->email}}}
        </li>
        
        @if ($user->about)
        <li class="list-group-item">
        <b>About:</b>
        <div class="newlineText well well-sm">{{{$user->about}}}</div>
        @endif
        </li>
        
        <li class="list-group-item">
            <b>User Group:</b>
            @if ($user->userGroup===1) Admin @endif
            @if ($user->userGroup===2) Employer @endif
            @if ($user->userGroup===3) Job Searcher @endif
        </li>
        <li class="list-group-item">
            <b>Joined:</b> {{{$user->created_at}}}
        </li>
              </ul>
                 </div>
    
</div>
    
@stop