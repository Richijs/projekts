@extends("layout")
@section("content")
    <h2>All Users</h2>
    <div>
        @if (isset($users))
            @foreach ($users as $user)
            <div>
                <a href="/viewUser/{{{$user->id}}}">{{{ $user->username }}}</a>
                <span>Joined: {{{$user->created_at}}}</span>
                <span>
                    Status:
                    @if ($user->status===1)
                        Active!
                    @elseif ($user->status===0)
                        Inactive!
                    @else
                        Banned!
                    @endif
                </span>
            </div>
            @endforeach
        @else
            <div>No Users to show</div>
        @endif
    </div>
@stop