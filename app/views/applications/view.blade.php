@extends("layout")
@section("content")

    <span class="page-control btn-group btn-group-sm">
        <a class="btn btn-default" href="{{URL::to("/viewUser/".$user->id)}}">{{{$user->username}}} {{ trans('buttons.profile') }}</a>
        <a class="btn btn-default" href="{{URL::to("/viewVacancie/".$vacancie->id)}}">{{ trans('buttons.to-vacancie') }}</a>
        
        @if (@Auth::check() && (Auth::user()->id == $application->user_id || Auth::user()->userGroup==1))
            <a class="btn btn-warning" href="{{URL::to("/editApplication/".$application->id)}}">{{ trans('buttons.edit-application') }}</a>
            <a class="btn btn-danger" href="{{URL::to("/deleteApplication/".$application->id)}}">{{ trans('buttons.delete-application') }}</a>   
        @endif
        
        @if (@Auth::check() && (Auth::user()->id == $seeker->user_id || Auth::user()->userGroup==1))
            <a class="btn btn-warning" href="{{URL::to("/editJobSeek/".$seeker->id)}}">{{ trans('buttons.edit-jobseek-data') }}</a>
            <a class="btn btn-danger" href="{{URL::to("/editJobSeek/".$seeker->id)}}">{{ trans('buttons.delete-jobseek-data') }}</a>
        @endif
    </span>
    
    <div class="page-header">
        <h2>{{ trans('titles.application-for-vacancie') }}
            <div><small>"<a href="{{URL::to("/viewVacancie/".$vacancie->id)}}">{{{$vacancie->name}}}</a>"</small></div>
        </h2>
    </div>
    
    <div class="row col-sm-10 col-sm-offset-1">
        <b>{{ trans('forms.letter') }}:</b>
        <span class="pull-right">
            {{ trans('content.applied-at') }} <b>{{{ date('d.m.y H:i',strtotime($application->created_at))}}}</b>
        </span>
    </div>

    <div class="midVacancieRow row col-sm-10 col-sm-offset-1">
        <div class="newlineText well">{{{$application->letter}}}</div>
    </div>

    <div class="row col-sm-10 col-sm-offset-1">
        <b>{{ trans('content.jobseeker-data') }}:</b> <a href="{{URL::to("/viewSeeker/".$seeker->id)}}">{{{ $seeker->intro }}}</a>
        <span class="pull-right">
            <a href="{{URL::to("/viewUser/".$user->id)}}">{{{ $user->username }}}</a>
            {{ trans('content.searching-for-job-since') }} <b> {{{ date('d.m.y H:i',strtotime($seeker->created_at)) }}} </b>
        </span>
    </div>
 
    <div class="row col-sm-10 col-sm-offset-1">
        <div class="newlineText well">{{{$seeker->text}}}</div>
    </div>

    <div class="row col-sm-10 col-sm-offset-1">
        <a class="btn btn-info" href="{{ URL::to("/getCV/".$seeker->id) }}">{{ trans('buttons.download-cv') }}</a>
        <span class="pull-right">
            @if (isset($seeker->phone) && $seeker->phone!='')
            <div>
                <b>{{ trans('forms.phone') }}: </b><a href="tel:{{{$seeker->phone}}}">{{{$seeker->phone}}} </a>
            </div>
            @endif
            <div>
                <b>{{ trans('forms.email') }}: </b><a href="mailto:{{{$user->email}}}">{{{$user->email}}}</a>
            </div>
        </span>
    </div>

    <div class="row col-sm-12">&nbsp;</div>

@stop