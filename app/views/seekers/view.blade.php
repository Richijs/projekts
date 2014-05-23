@extends("layout")
@section("content")

    <span class="page-control btn-group btn-group-sm">
        @if (Auth::user()->id == $seeker->user_id)
            <a class="btn btn-default" href="{{ URL::to("/profile/")}}">{{ trans('buttons.my-profile') }}</a>
        @else
            <a class="btn btn-default" href="{{URL::to("/viewUser/".$seeker->user_id)}}">{{{$seeker->creatorName}}} {{ trans('buttons.profile') }}</a>
        @endif
        
        @if (@Auth::check() && (Auth::user()->id == $seeker->user_id || Auth::user()->userGroup==1))
            <a class="btn btn-warning" href="{{URL::to("/editJobSeek/".$seeker->id)}}">{{ trans('buttons.edit-jobseek-data') }}</a>
            <a class="btn btn-danger" href="{{URL::to("/deleteJobSeek/".$seeker->id)}}">{{ trans('buttons.delete-jobseek-data') }}</a>
        @endif
        
        @if (Auth::user()->userGroup != 3)
            <a class="btn btn-default" href="{{URL::to("/viewAllSeekers")}}">{{ trans('buttons.all-job-seekers') }}</a>
        @endif
    </span>    

    <div class="page-header">
        <h1>
            <a href="{{URL::to("/viewUser/".$seeker->user_id)}}">
                @if (Auth::user()->id == $seeker->user_id)
                    {{ trans('titles.your') }}
                @else
                    {{{$seeker->creatorName}}}
                @endif
            </a>
                {{ trans('titles.job-seeker-data') }}
        </h1>
    </div>

    <div class="row col-sm-10 col-sm-offset-1">
        <b>{{ trans('content.jobseeker-data') }}:</b> <a href="{{URL::to("/viewSeeker/".$seeker->id)}}">{{{ $seeker->intro }}}</a>
        <span class="pull-right">
            <a href="{{URL::to("/viewUser/".$seeker->user_id)}}">
                @if (Auth::user()->id == $seeker->user_id)
                    {{ trans('titles.you') }}</a> {{ trans('content.are searching-for-job-since') }} 
                @else
                    {{{$seeker->creatorName}}}</a> {{ trans('content.searching-for-job-since') }} 
                @endif
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
    
@stop