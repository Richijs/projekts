@extends("layout")
@section("content")

    <span class="page-control btn-group btn-group-sm">
        <a class="btn btn-default" href="{{ URL::to("/profile/")}}">{{ trans('buttons.my-profile') }}</a>
        @if (isset($seeker))
            <a class="btn btn-warning" href="{{URL::to("/editJobSeek/".$seeker->id)}}">{{ trans('buttons.edit-jobseek-data') }}</a>
            <a class="btn btn-danger" href="{{URL::to("/deleteJobSeek/".$seeker->id)}}">{{ trans('buttons.delete-jobseek-data') }}</a>
        @else
            <a class="btn btn-success" href="{{ URL::route("seekers/add") }}">{{ trans('titles.add-jobseek-data') }}</a>
        @endif
        
        @if (Auth::user()->userGroup == 1)
            <a class="btn btn-default" href="{{URL::to("/viewAllSeekers")}}">{{ trans('buttons.all-job-seekers') }}</a>
        @endif
    </span>   
    
    <div class="page-header">
        <h2>
            {{ trans('titles.your-jobsearch-data') }},  <small>{{{ Auth::user()->username }}}</small>
        </h2>
    </div>

@if (isset($seeker))

    <div class="row col-sm-10 col-sm-offset-1">
        <b> <a href="{{URL::to("/viewSeeker/".$seeker->id)}}">{{{ $seeker->intro }}}</a> </b>
        <span class="pull-right">
            <a href="{{URL::to("/viewUser/".$seeker->user_id)}}">
                {{ trans('titles.you') }}
            </a>
            {{ trans('content.are searching-for-job-since') }} 
            <b> {{{ date('d.m.y H:i',strtotime($seeker->created_at)) }}} </b>
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
        </span>
    </div>

    <div class="row col-sm-12">&nbsp;</div>

@else

<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title">
            <b>{{ trans('content.you-havent-added-seeker-data-yet') }} </b>
        </div>
    </div>
</div>

@endif

@stop