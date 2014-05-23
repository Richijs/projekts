@extends("layout")
@section("content")
    
    <span class="page-control btn-group btn-group-sm">
        @if (Auth::check() && Auth::user()->userGroup == 1)
            <a class="btn btn-default" href="{{ URL::to("/myJobSeek/")}}">{{ trans('buttons.my-jobseek') }}</a>
        @endif
    </span>  

    <div class="page-header">
        <h2>
            {{ trans('titles.job-searchers') }}
        </h2>
    </div>

@if (isset($seekers))

<div class='table-responsive'>
<table class='table'>
    <thead>
        <tr>
            <th>{{ trans('content.intro-title') }}</th>
            <th>{{ trans('content.user') }}</th>
            <th>{{ trans('content.searching-since') }}</th>
            <th>{{ trans('content.actions') }}</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($seekers as $seeker)
        <tr>
            <td>
                <a href="{{URL::to("/viewSeeker/".$seeker->id)}}">{{{ $seeker->intro }}}</a>
            </td>
                    
            <td>
                <a href="{{URL::to("/viewUser/".$seeker->user_id)}}">{{{ $seeker->creatorName }}}</a>
            </td>
                    
            <td>
                {{{ date('d.m.y H:i',strtotime($seeker->created_at)) }}}
            </td>
                    
            <td>
                <a class="btn btn-info btn-xs" href="{{ URL::to("/getCV/".$seeker->id) }}">{{ trans('buttons.download-cv') }}</a>
                @if (Auth::check() && Auth::user()->userGroup==1)
                    <a class="btn btn-warning btn-xs" href="{{URL::to("/editJobSeek/".$seeker->id)}}">{{ trans('buttons.edit-jobseek-data') }}</a>
                    <a class="btn btn-danger btn-xs" href="{{URL::to("/deleteJobSeek/".$seeker->id)}}">{{ trans('buttons.delete-jobseek-data') }}</a>
                @endif
            </td>
                    
        </tr>
    @endforeach
    </tbody>
</table>
</div>
        
<div>
    {{$seekers->links()}} <!-- pagination links -->
</div>

@else

<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title">
            <b>{{ trans('content.no-jobseekers-to-show') }}</b>
        </div>
    </div>
</div>

@endif

@stop