@extends("layout")
@section("content")
<h2>All who recommended <a href="/viewUser/{{{$employer->id}}}">{{{$employer->username}}}</a></h2>
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
            <div>No recommendations yet</div>
        @endif
    </div>
@stop