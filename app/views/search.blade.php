@extends("layout")
@section("content")

    
    @if (isset($users) && count($users))
        
        <h3>Users Found<b>({{count($users)}})</b>:</h3>
        @foreach($users as $user)
        
        <div>
            <a href="/viewUser/{{{$user->id}}}">{{{ $user->username }}}</a>
        </div>
        
        @endforeach

    @endif
    
    @if (isset($vacancies) && count($vacancies))
        
        <h3>Vacancies Found<b>({{count($vacancies)}})</b>:</h3>
        @foreach($vacancies as $vacancie)
        
        <div>
            <a href="/viewVacancie/{{{$vacancie->id}}}">{{{ $vacancie->name }}}</a>
        </div>
        
        @endforeach

    @endif
    
    @if (isset($seekers) && count($seekers))
        
        <h3>Job Searchers Found<b>({{count($seekers)}})</b>:</h3>
        @foreach($seekers as $seeker)
        
        <div>
            <a href="/viewSeeker/{{{$seeker->id}}}">{{{ $seeker->intro }}}</a>
        </div>
        
        @endforeach

    @endif
    
    @if (!isset($users) && !isset($vacancies) && !isset($seekers))
        <h3> Nothing was found at all </h3>
    @elseif (!count($users) && !count($vacancies) && (!isset($seekers) || !count($seekers)))
        <h3>No Results match the search</h3>    
    @endif
    
@stop
@section("footer")
    @parent
    <script src="/js/polyfill.io"></script>
@stop