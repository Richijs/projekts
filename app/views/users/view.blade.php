@extends("layout")
@section("content")
    <h2>Viewing: <a href="{{ URL::to("/viewUser/".$user->id) }}">{{{ $user->username }}}</a> Public profile</h2>
    <div>
        UserGroup:
        @if ($user->userGroup===1)
            Admin
        @elseif ($user->userGroup===2)
            Employer
        @elseif ($user->userGroup===3)
            Job Seeker
        @endif
    </div>
    <div>
        <b>Status:</b>
        @if ($user->active===1)
            Active!
        @else
            Not Activated!
        @endif
    </div>
    <div>
        email: <a href="mailto:{{{$user->email}}}">{{{$user->email}}}</a>
    </div>
    @if ($user->picture)
        <div>
            <img src="{{URL::to('/')}}/{{{$user->picture}}}" width="200" alt="user picture"/>
        </div>
    @else
        <div>
            <img src="{{URL::to('/')}}/uploads/profileImages/default.jpeg" width="200" alt="profile picture"/>
        </div>
    @endif
    <div>
        Joined: {{{$user->created_at}}}
    </div>
@stop