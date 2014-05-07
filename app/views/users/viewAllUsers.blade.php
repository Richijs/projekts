@extends("layout")
@section("content")
    <h2>All Users</h2>
    <div>
        @if (isset($users))
            @foreach ($users as $user)
            <div>
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
            </div>
            @endforeach
            <div>
                {{$users->links()}} <!-- pagination links -->
            </div>
        @else
            <div>No Users to show</div>
        @endif
    </div>
@stop