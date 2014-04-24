@extends("layout")
@section("content")
    <h2>Viewing Application for</h2>
    <h3><a href="/viewVacancie/{{{/*$vacancie->id*/}}}">{{{/*$vacancie->name*/}}}</a></h3>
    
    <div>
        {{{$application->letter}}}
    </div>
   
    <div>
        Te vajag savus detalizētākus seeker datus
    </div>
    
    
    <div>
        <b>Applied at:</b> {{{$application->created_at}}}
        
    </div>
@stop