@extends("layout")
@section("content")
<h2>Users who <a href="/viewUser/{{{$user->id}}}">{{{$user->username}}}</a> has recommended</h2>
    <div>
        @if (isset($recommendations))
            @foreach ($recommendations as $recommendation)
            <div>
                <b>Recommended</b>
                
                <a href="/viewUser/{{{$recommendation->user->id}}}">{{{$recommendation->user->username}}}</a>
                <a href="/viewRecommenders/{{{$recommendation->user->id}}}">({{{$recommendation->userRecommends}}})</a>

                @if (Auth::check() && $recommendation->user->id!=Auth::user()->id && $recommendation->user->userGroup!=3)
                <span>
                    <a href="/recommend/{{{$recommendation->user->id}}}">
                        <button class="btn btn-default">
                            @if ($recommendation->recommended)
                                <span class="glyphicon glyphicon-remove-circle"></span>
                                <span class="glyphicon glyphicon-thumbs-up"></span>
                            @else
                                <span class="glyphicon glyphicon-thumbs-up"></span>
                            @endif
                        </button>
                    </a>
                </span>
                @endif
                
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