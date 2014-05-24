@extends("layout")
@section("content")

<div class="page-header">
    <h2>{{ trans('titles.search-results') }}</h2>
</div>  

<div class="col-sm-offset-2 col-sm-8">

@if (isset($users) && count($users))
    <h4 class="search-title">
        {{ trans('content.users-found') }} <b>({{count($users)}})</b>:
    </h4>
        @foreach($users as $user)
        <div>
            <a href="/viewUser/{{{$user->id}}}">{{{ $user->username }}}</a>
            @if (Auth::check() && Auth::user()->id != $user->id)
                <a class="btn btn-default btn-xs" href="{{{ URL::to("/sendMessage/".$user->id) }}}">
                    {{ trans('forms.send-message') }}
                </a>
            @endif
        </div>
        @endforeach
@endif
    
@if (isset($vacancies) && count($vacancies))
    <h4 class="search-title">
        {{ trans('content.vacancies-found') }} <b>({{count($vacancies)}})</b>:
    </h4>
        @foreach($vacancies as $vacancie)
        <div>
            <a href="/viewVacancie/{{{$vacancie->id}}}">{{{ $vacancie->name }}}</a>
        </div>
        @endforeach 
@endif

@if (isset($seekers) && count($seekers))
    <h4 class="search-title">
        {{ trans('content.job-searchers-found') }} <b>({{count($seekers)}})</b>:
    </h4>
        @foreach($seekers as $seeker)
        <div>
            <a href="/viewSeeker/{{{$seeker->id}}}">{{{ $seeker->intro }}}</a>
        </div>
        @endforeach
@endif
    
@if (!isset($users) && !isset($vacancies) && !isset($seekers))
    <div class="panel panel-warning">
        <div class="panel-heading">
            <div class="panel-title">
                <b>{{ trans('content.searched-for-nothing') }}</b>
            </div>
        </div>
    </div>
    @elseif ((!isset($users) || !count($users)) && !count($vacancies) && (!isset($seekers) || !count($seekers)))
    <div class="panel panel-warning">
        <div class="panel-heading">
            <div class="panel-title">
                <b>{{ trans('content.no-results-found') }}</b>
            </div>
        </div>
    </div>  
@endif

</div>

<div class="row col-sm-12">&nbsp;</div>

@stop