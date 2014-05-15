@extends("layout")
@section("content")

<div class="page-header">
    <h1>Search results</h1>
</div>  
    
    @if (isset($users) && count($users))
        
    <div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">
            Users Found <b>({{count($users)}})</b>:
        </div>
    </div>
    <div class="panel-body">
    
    
        @foreach($users as $user)
        
        <div>
            <a href="/viewUser/{{{$user->id}}}">{{{ $user->username }}}</a>
        </div>
        
        @endforeach
    </div>
    </div>
    @endif
    
    
    
    @if (isset($vacancies) && count($vacancies))
        
        <div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">
            Vacancies Found <b>({{count($vacancies)}})</b>:
        </div>
    </div>
    <div class="panel-body">

        @foreach($vacancies as $vacancie)
        
        <div>
            <a href="/viewVacancie/{{{$vacancie->id}}}">{{{ $vacancie->name }}}</a>
        </div>
        
        @endforeach
    </div>
        </div>
    @endif
    
    
    
    @if (isset($seekers) && count($seekers))
        
    <div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">
             Job Searchers Found <b>({{count($seekers)}})</b>:
        </div>
    </div>
    <div class="panel-body">
    
       
        @foreach($seekers as $seeker)
        
        <div>
            <a href="/viewSeeker/{{{$seeker->id}}}">{{{ $seeker->intro }}}</a>
        </div>
        
        @endforeach
    </div>
    </div>
    @endif
    
    
    
    @if (!isset($users) && !isset($vacancies) && !isset($seekers))
        <div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title">
            <b>You searched for... nothing.</b>
        </div>
    </div>
</div>
    @elseif (!count($users) && !count($vacancies) && (!isset($seekers) || !count($seekers)))
        <div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title">
            <b>No Results found.</b>
        </div>
    </div>
</div>  
    @endif
    
@stop