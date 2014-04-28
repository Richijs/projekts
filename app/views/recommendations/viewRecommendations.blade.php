@extends("layout")
@section("content")
<h2>Users who <a href="/viewUser/{{{$user->id}}}">{{{$user->username}}}</a> has recommended</h2>
    <div>
        @if (isset($recommendations))
            @foreach ($recommendations as $recommendation)
            <div>
                
                <a href="/viewUser/{{{$recommendation->user->id}}}">{{{$recommendation->user->username}}}</a>
                <b>at</b>
                {{{$recommendation->created_at}}}
                
            </div>
            @endforeach
            <div>
                {{$recommendations->links()}} <!-- pagination links -->
            </div>
        @else
            <div>No recommendations done yet</div>
        @endif
    </div>
@stop