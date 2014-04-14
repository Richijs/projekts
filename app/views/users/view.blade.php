@extends("layout")
@section("content")
    <h2>Viewing: <a href="{{ URL::to("/viewUser/".$user->id) }}">{{{ $user->username }}}</a> Public profile</h2>
    <div>
        UserGroup:
        @if ($user->userGroup===1)
            Admin
        @elseif ($user->userGroup===3)
            User
        @endif
    </div>
    <div>
        email: <a href="mailto:{{{$user->email}}}">{{{$user->email}}}</a>
    </div>
    <div>
        Joined: {{{$user->created_at}}}
    </div>
@stop