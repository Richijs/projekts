@extends("layout")
@section("content")
    
    <div class="page-header">
        <h1>Viewing application for 
            <small><a href="/viewVacancie/{{{$vacancie->id}}}">{{{$vacancie->name}}}</a></small>
        </h1>
    </div>
    
    <h3>Motivation Letter</h3>
    <div>
        {{{$application->letter}}}
    </div>
    <div>
        <b>Applied at:</b> {{{$application->created_at}}}
        <b>Edited at:</b> {{{$application->updated_at}}}
    </div>
    @if (@Auth::check() && (Auth::user()->id == $application->user_id || Auth::user()->userGroup==1))
        <a class="btn btn-warning" href="/editApplication/{{{$application->id}}}">edit application letter data</a>
        <a class="btn btn-danger" href="/deleteApplication/{{{$application->id}}}">delete application letter data</a>
    @endif
   
    <h3>Job Searcher Data</h3>
    <h3><a href="/viewSeeker/{{{$seeker->id}}}">{{{ $seeker->intro }}}</a></h3>
    

    <div>
         <a href="{{ URL::to("/getCV/".$seeker->id) }}">DOWNLOAD CV</a>
    </div>

    <div>
        {{{$seeker->text}}}
    </div>
    <div>
        Searching for job since: {{{$seeker->created_at}}}
    </div>
    
@stop