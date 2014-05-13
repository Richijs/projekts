@extends("layout")
@section("content")

<div class="page-header">
    <h1>
        All Users
    </h1>
</div>

    <div>
        @if (isset($users))
        
        <table class='table'>
            <thead>
                <tr>
                    <th>Picture</th>
                    <th>Username</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
            
                @if ($user->picture)
                <span>
                    <img src="{{URL::to('/')}}/{{{$user->picture}}}" width="50" height="50" alt="user picture"/>
                </span>
                @else
                <span>
                    <img src="{{URL::to('/')}}/uploads/profileImages/default.jpeg" width="50" height="50" alt="profile picture"/>
                </span>
                @endif
                <!-- else - shows default picture -->
                <a href="/viewUser/{{{$user->id}}}">{{{ $user->username }}}</a>
                <span><b>Joined:</b> {{{ date('d.m.y H:i',strtotime($user->created_at)) }}}</span>
                <span>
                    <b>Status:</b>
                    @if ($user->active===1)
                        Active!
                    @else
                        Not Activated!
                    @endif
                </span>
                
                @if (Auth::check() && Auth::user()->userGroup==1 && Auth::user()->id!=$user->id)
                    <span>
                        <a class="btn btn-warning" href="{{{ URL::to("/editUser/".$user->id) }}}">Edit User</a>
                        <a class="btn btn-danger" href="{{{ URL::to("/deleteUser/".$user->id) }}}">Delete User</a>
                    </span>
                @endif
            
            @endforeach
            </tbody>
        </table>
            
            <div>
                {{$users->links()}} <!-- pagination links -->
            </div>
        @else
            <div>No Users to show</div>
        @endif
    </div>
@stop