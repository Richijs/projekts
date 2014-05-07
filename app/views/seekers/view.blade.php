@extends("layout")
@section("content")
    <h2>Viewing {{{$seeker->creatorName}}} job seek</h2>
    <h3><a href="/viewSeeker/{{{$seeker->id}}}">{{{ $seeker->intro }}}</a></h3>
    

    <div>
         <a href="{{ URL::to("/getCV/".$seeker->id) }}">
             <button class="btn btn-default">
                 DOWNLOAD CV
             </button>
         </a>
    </div>

    <div>
        {{{$seeker->text}}}
    </div>
    <div>
        <b>Added at:</b> {{{$seeker->created_at}}}
        
        <b>Last edit:</b> {{{$seeker->updated_at}}}
    </div>
@stop