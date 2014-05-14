@extends("layout")
@section("content")
    
    <div class="page-header">
        <h1>Viewing application for 
            <small><a href="{{URL::to("/viewVacancie/".$vacancie->id)}}">{{{$vacancie->name}}}</a></small>
        </h1>
    </div>
    
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">
            <b>Motivation Letter:</b>
            @if (@Auth::check() && (Auth::user()->id == $application->user_id || Auth::user()->userGroup==1))
                <span>
                    <a class="btn btn-warning" href="{{URL::to("/editApplication/".$application->id)}}">edit application letter data</a>
                    <a class="btn btn-danger" href="{{URL::to("/deleteApplication/".$application->id)}}">delete application letter data</a>
                </span>
            @endif
        </div>
    </div>
    <div class="panel-body">
        <div class="newlineText">{{{$application->letter}}}</div>
        <div class="pull-right">
            <b>Applied at:</b> {{{$application->created_at}}}
        </div>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">
            <b>Job Searcher Data:</b>
            <a href="{{URL::to("/viewSeeker/".$seeker->id)}}">{{{ $seeker->intro }}}</a>
            @if (@Auth::check() && (Auth::user()->id == $seeker->user_id || Auth::user()->userGroup==1))
                <span>
                    <a class="btn btn-warning" href="{{URL::to("/editJobSeek/".$seeker->id)}}">edit Job Searcher data</a>
                    <a class="btn btn-danger" href="{{URL::to("/editJobSeek/".$seeker->id)}}">delete Job Searcher data</a>
                </span>
            @endif
        </div>
    </div>
    <div class="panel-body">
        <div class="newlineText">{{{$seeker->text}}}</div>
        <div class="pull-right">
            <div>
                <a class="btn btn-default" href="{{ URL::to("/getCV/".$seeker->id) }}">DOWNLOAD CV</a>
            </div>
            <div>
                <a href="{{URL::to("/viewUser/".$user->id)}}">{{{ $user->username }}}</a>
                <b> is searching for Job since:</b> {{{$seeker->created_at}}}
            </div>
            <div class="pull-right">
                <b>Phone: </b><a href="tel:{{{$seeker->phone}}}">{{{$seeker->phone}}} </a>
                <b>Email: </b><a href="mailto:{{{$user->email}}}">{{{$user->email}}}</a>
            </div>
        </div>
    </div>
</div>
    
@stop