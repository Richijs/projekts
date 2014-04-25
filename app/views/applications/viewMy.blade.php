@extends("layout")
@section("content")
    <h2>Jobs You Have applied for , {{{ Auth::user()->username }}}</h2>
    <div>
        @if (isset($applications))
        <h3>
            You have applied for <b>{{{$applications->count}}}</b> jobs
        </h3>
            @foreach ($applications as $application)
            <div>
                <a href="/viewVacancie/{{{$application->vacancieId}}}">{{{ $application->vacancieName }}}</a>
                
                <span><b>applied at:</b> {{{ date('d.m.y H:i',strtotime($application->created_at)) }}}</span>
  
                <a href="/viewApplication/{{{$application->id}}}">View Your application</a>
                
            </div>
            @endforeach
            <div>
                {{$applications->links()}} <!-- pagination links -->
            </div>
        @else
            <div>You have'nt applied for any jobs</div>
        @endif
    </div>
@stop