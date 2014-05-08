@extends("layout")
@section("content")
    <h2>All Seekers</h2>
    <div>
        @if (isset($seekers))
            @foreach ($seekers as $seeker)
            <div>
                <a href="/viewSeeker/{{{$seeker->id}}}">{{{ $seeker->intro }}}</a>
                <span><b>created at:</b> {{{ date('d.m.y H:i',strtotime($seeker->created_at)) }}}</span>
                
                <span>
                    <a class="btn btn-default" href="{{ URL::to("/getCV/".$seeker->id) }}">
                        DOWNLOAD CV
                    </a>
                </span>
                
                <span>
                    <b> Added by: </b>
                    <a href="/viewUser/{{{$seeker->user_id}}}">{{{ $seeker->creatorName }}}</a>
                </span>
                
            </div>
            @endforeach
            <div>
                {{$seekers->links()}} <!-- pagination links -->
            </div>
        @else
            <div>No Seekers to show</div>
        @endif
    </div>
@stop