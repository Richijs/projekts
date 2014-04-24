@extends("layout")
@section("content")
    <h2>Viewing Application for</h2>
    <h3><a href="/viewVacancie/{{{$vacancie->id}}}">{{{$vacancie->name}}}</a></h3>
    
    <h3>Motivation Letter</h3>
    <div>
        {{{$application->letter}}}
    </div>
   
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