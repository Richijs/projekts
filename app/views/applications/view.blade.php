@extends("layout")
@section("content")
    <h2>Viewing Application for</h2>
    <h3><a href="/viewVacancie/{{{$vacancie->id}}}">{{{$vacancie->name}}}</a></h3>
    
    <h3>Motivation Letter</h3>
    <div>
        {{{$application->letter}}}
    </div>
    @if (@Auth::check() && (Auth::user()->id == $application->user_id || Auth::user()->userGroup==1))
    <a href="/editApplication/{{{$application->id}}}"><div class="btn btn-warning">edit application letter data</div></a>
    <a href="/deleteApplication/{{{$application->id}}}"><div class="btn btn-danger">delete application letter data</div></a>
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
        <b>Applied job seeker data at:</b> {{{$application->created_at}}}
        
    </div>
@stop