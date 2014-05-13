@extends("layout")
@section("content")

    <div class="page-header">
        <h1>Applicants applied for 
            <small><a href="/viewVacancie/{{{$applications->vacancie->id}}}">{{{$applications->vacancie->name}}}</a></small>
        </h1>
    </div>

    <div>
        @if (isset($applications))
        <h3>
            <b>{{{$applications->count}}}</b> applicants have applied!
        </h3>
            @foreach ($applications as $application)
            <div>
                <a href="/viewUser/{{{$application->user->id}}}">{{{$application->user->username}}}</a>
            
                <span><b>applied at:</b> {{{ date('d.m.y H:i',strtotime($application->created_at)) }}}</span>
                <a href="/viewApplication/{{{$application->id}}}">view {{{$application->user->username}}}'s application</a>

                
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