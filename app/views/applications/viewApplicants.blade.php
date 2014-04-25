@extends("layout")
@section("content")
    <h2>Your applicants , {{{ Auth::user()->username }}} for 
        <a href="/viewVacancie/{{{$applications->vacancie->id}}}">{{{$applications->vacancie->name}}}</a>
    </h2>
    <div>
        @if (isset($applications))
        <h3>
            <b>{{{$applications->count}}}</b> applicants have applied!
        </h3>
            @foreach ($applications as $application)
            <div>
                <a href="/viewUser/{{{$application->user->id}}}">{{{$application->user->username}}}'s</a>
                <a href="/viewApplication/{{{$application->id}}}">application</a>
                
                <span><b>applied at:</b> {{{ date('d.m.y H:i',strtotime($application->created_at)) }}}</span>
  
                
            </div>
            @endforeach
            <div>
                {{$applications->links()}} <!-- pagination links -->
            </div>
        @else
            <div>No applicants have applied yet</div>
        @endif
    </div>
@stop