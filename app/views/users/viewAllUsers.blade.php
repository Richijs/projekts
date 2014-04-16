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
                    @if ($user->active===1)
                        Active!
                    @elseif ($user->active===0)
                        Inactive!
                    @else
                        Banned!
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