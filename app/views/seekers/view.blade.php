@extends("layout")
@section("content")

    <div class="page-header">
        <h1>
            Viewing {{{$seeker->creatorName}}} job seek
            <small><a href="/viewSeeker/{{{$seeker->id}}}">{{{ $seeker->intro }}}</a></small>
        </h1>
    </div>

    <div>
         <a class="btn btn-default" href="{{ URL::to("/getCV/".$seeker->id) }}">DOWNLOAD CV</a>
    </div>

    <div>
        {{{$seeker->text}}}
    </div>
    <div>
        <b>Added at:</b> {{{$seeker->created_at}}}
        
        <b>Last edit:</b> {{{$seeker->updated_at}}}
    </div>
@stop