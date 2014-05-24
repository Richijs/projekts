@extends("layout")
@section("content")

<div class="page-header">
    <h2>{{ trans('titles.search-results') }}</h2>
</div>  

<div class="col-sm-offset-2 col-sm-8">

@if (isset($users) && count($users))
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title">
                {{ trans('content.users-found') }} <b>({{count($users)}})</b>:
            </div>
        </div>
        <div class="panel-body">
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
        </div>
    </div>
@endif
    
@if (isset($vacancies) && count($vacancies))
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title">
                {{ trans('content.vacancies-found') }} <b>({{count($vacancies)}})</b>:
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
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title">
                {{ trans('content.job-searchers-found') }} <b>({{count($seekers)}})</b>:
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

@stop