@extends("layout")
@section("content")

<div class="page-header">
    <h1>
        All Users
    </h1>
</div>

    <div>
        @if (isset($users))
        <div class='table-responsive'>
        <table class='table'>
            <thead>
                <tr>
                    <th>Picture</th>
                    <th>Username</th>
                    <th>Status</th>
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
                <a href="/viewUser/{{{$user->id}}}">{{{ $user->username }}}</a>
                </td>
                
                <td>
                <span>
                    @if ($user->active===1)
                        Active!
                    @else
                        Not Activated!
                    @endif
                </span>
                </td>
                
                
                <td>
                    <b>Joined:</b> {{{ date('d.m.y H:i',strtotime($user->created_at)) }}}
                </td>
                
                
                @if (Auth::check() && Auth::user()->userGroup==1 && Auth::user()->id!=$user->id)
                    <td>
                        <a class="btn btn-warning" href="{{{ URL::to("/editUser/".$user->id) }}}">Edit User</a>
                        <a class="btn btn-danger" href="{{{ URL::to("/deleteUser/".$user->id) }}}">Delete User</a>
                    </td>
                @endif
                
                
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
        
            <div>
                {{$users->links()}} <!-- pagination links -->
            </div>
        @else
            <div>No Users to show</div>
        @endif
    </div>
@stop