@extends("layout")
@section("content")

    <div class="page-header">
        <h1>
            Viewing <a href="{{URL::to("/viewUser/".$seeker->user_id)}}">{{{$seeker->creatorName}}}</a> Job Searcher data
        </h1>
    </div>

    <div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">
            <b>Job Searcher Data:</b>
            <a href="{{URL::to("/viewSeeker/".$seeker->id)}}">{{{ $seeker->intro }}}</a>
            @if (@Auth::check() && (Auth::user()->id == $seeker->user_id || Auth::user()->userGroup==1))
                <span>
                    <a class="btn btn-warning" href="{{URL::to("/editJobSeek/".$seeker->id)}}">edit Job Searcher data</a>
                    <a class="btn btn-danger" href="{{URL::to("/deleteJobSeek/".$seeker->id)}}">delete Job Searcher data</a>
                </span>
            @endif
        </div>
    </div>
    <div class="panel-body">
        <div class="newlineText">{{{$seeker->text}}}</div>
        <div class="pull-right">
            <div>
                <b>Phone: </b><a href="tel:{{{$seeker->phone}}}">{{{$seeker->phone}}} </a>
                <a class="btn btn-default" href="{{ URL::to("/getCV/".$seeker->id) }}">DOWNLOAD CV</a>
            </div>
            <div>
                <b>
                    <a href="{{URL::to("/viewUser/".$seeker->user_id)}}">{{{ $seeker->creatorName }}}</a>
                    is searching for Job since:
                </b> {{{$seeker->created_at}}}
            </div>
        </div>
    </div>
</div>
    
@stop