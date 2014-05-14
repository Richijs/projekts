@extends("layout")
@section("content")

    <div class="page-header">
        <h1>
            Your added Job Search data,  <small>{{{ Auth::user()->username }}}</small>
        </h1>
    </div>

@if (isset($seeker))
    <div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">
            <b>Job Searcher Data:</b>
            <a href="{{URL::to("/viewSeeker/".$seeker->id)}}">{{{ $seeker->intro }}}</a>
            @if (@Auth::check() && Auth::user()->id == $seeker->user_id)
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
                    <a href="{{URL::to("/viewUser/".$seeker->user_id)}}">You</a>
                    are searching for Job since:
                </b> {{{$seeker->created_at}}}
            </div>
        </div>
    </div>
</div>
@else

<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title">
            <b>You have'nt added your job seeker data yet</b>
        </div>
        <div class="panel-body">
            <a class="btn btn-success" href="{{ URL::route("seekers/add") }}">Add JobSeeker data</a>
        </div>
    </div>
</div>

@endif

@stop