@extends("layout")
@section("content")
    
    <div class="page-header">
        <h1>Jobs You have applied to, 
            <small>{{{ Auth::user()->username }}}</small>
        </h1>
    </div>
    
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
                
                <a class="btn btn-warning" href="/editApplication/{{{$application->id}}}">edit application letter data</a>
                <a class="btn btn-danger" href="/deleteApplication/{{{$application->id}}}">delete application letter data</a>

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