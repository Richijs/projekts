@extends("layout")
@section("content")

<div class="page-header">
    <h1>
        All Users
    </h1>
</div>


        @if (isset($users))
        
    <div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">
            All User List
        </div>
    </div>
    <div class="panel-body">
            
        
        
        <div class='table-responsive'>
        <table class='table'>
            <thead>
                <tr>
                    <th>Picture</th>
                    <th>Username</th>
                    <th>Status</th>
                    <th>User Group</th>
                    <th>Joined</th>
                    @if (Auth::check() && Auth::user()->userGroup==1)
                    <th>Controls</th>
                    @endif
                </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr>
                    
                <td>  
                @if ($user->picture)
                
                    <img src="{{URL::to('/')}}/{{{$user->picture}}}" width="50" height="50" alt="user picture"/>
                
                @else
                
                    <img src="{{URL::to('/')}}/uploads/profileImages/default.jpeg" width="50" height="50" alt="profile picture"/>
                
                @endif
                <!-- else - shows default picture -->
                </td>
                
                <td>
                <a href="{{ URL::to("/viewUser/".$user->id)}}">{{{ $user->username }}}</a>
                </td>
                
                <td>

                    @if ($user->active===1)
                        Active!
                    @else
                        Not Activated!
                    @endif

                </td>
                
                <td>
                    
                    @if ($user->userGroup===1) Admin @endif
                    @if ($user->userGroup===2) Employer @endif
                    @if ($user->userGroup===3) Job Searcher @endif
                    
                </td>    
                
                <td>
                    {{{ date('d.m.y H:i',strtotime($user->created_at)) }}}
                </td>
                
                
                @if (Auth::check() && Auth::user()->userGroup==1 && Auth::user()->id!=$user->id)
                    <td>
                        <a class="btn btn-warning" href="{{{ URL::to("/editUser/".$user->id) }}}">Edit User</a>
                        <a class="btn btn-danger" href="{{{ URL::to("/deleteUser/".$user->id) }}}">Delete User</a>
                    </td>
                @elseif (Auth::check() && Auth::user()->userGroup==1 && Auth::user()->id==$user->id)
                    <td>
                        <a class="btn btn-warning" href="#" disabled="disabled"> Edit User </a>
                        <a class="btn btn-danger" href="#" disabled="disabled"> Delete User </a>
                    </td>
                @endif
                
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
    </div>
            <div>
                {{$users->links()}} <!-- pagination links -->
            </div>
        @else
           
<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title">
            <b>No Users to show.</b>
        </div>
    </div>
</div>       
        
        
        @endif

        
@stop