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
        email: <a href="mailto:{{{$user->email}}}">{{{$user->email}}}</a>
    </div>
    @if ($user->picture)
        <div>
            <div>profile pic</div>
            <img src="{{URL::to('/')}}/{{{$user->picture}}}" alt="user picture"/>
        </div>
    @endif
    <div>
        Joined: {{{$user->created_at}}}
    </div>
@stop