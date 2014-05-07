@extends("layout")
@section("content")
    <h2>Your added job seeker data , {{{ Auth::user()->username }}}</h2>
    <div>
        @if (isset($seeker))
            <div>
                <a href="/viewSeeker/{{{$seeker->id}}}">{{{ $seeker->intro }}}</a>
                <div>
                    <b>created at:</b> {{{ date('d.m.y H:i',strtotime($seeker->created_at)) }}}
                    <b>Last edit:</b> {{{$seeker->updated_at}}}
                </div>
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
                    <a href="{{ URL::to("/editJobSeek/".$seeker->id) }}">Edit job seek data</a>
                </div>
            </div>
        @else
            <div>You have'nt added your job seeker data yet</div>
        @endif
    </div>
@stop