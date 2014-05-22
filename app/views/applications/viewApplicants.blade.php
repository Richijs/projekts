@extends("layout")
@section("content")

    <span class="page-control btn-group btn-group-sm">
        <a class="btn btn-default" href="{{URL::to("/viewVacancie/".$applications->vacancie->id)}}">{{ trans('buttons.to-vacancie') }}</a>
        <a class="btn btn-default" href="{{URL::to("/myVacancies")}}">{{ trans('buttons.my-vacancies') }}</a>
        <a class="btn btn-default" href="{{URL::to("/viewAllVacancies")}}">{{ trans('buttons.all-vacancies') }}</a>
    </span>

    <div class="page-header">
        <h2>
            @if (isset($applications))
                {{{$applications->count}}}
            @endif
            
            {{ trans('titles.applicants-applied-for-vacancie') }}
            <small><a href="{{URL::to("/viewVacancie/".$applications->vacancie->id)}}">{{{$applications->vacancie->name}}}</a></small>
        </h2>
    </div>

@if (isset($applications)) 
        
<div class='table-responsive'>
<table class='table'>
    <thead>
        <tr>
            <th>{{ trans('content.user') }}</th>
            <th>{{ trans('content.applied-at') }}</th>
            <th>{{ trans('content.view') }}</th>
            @if (Auth::user()->userGroup == 1) <th>{{ trans('content.controls') }}</th> @endif
        </tr>
    </thead>
    <tbody>
        @foreach ($applications as $application)
        <tr>
            <td>
                <a href="{{URL::to("/viewUser/".$application->user->id)}}">{{{$application->user->username}}}</a>                   
            </td>
                    
            <td>
                {{{ date('d.m.y H:i',strtotime($application->created_at)) }}}
            </td>
                    
            <td>
                <a class="btn btn-default btn-xs" href="{{URL::to("/viewApplication/".$application->id)}}">
                    {{ trans('content.view') }} {{{$application->user->username}}} {{ trans('titles.application-u') }}
                            
                    @if (isset($application->new))
                        <span class="badge">{{ trans('content.new') }}!</span>
                    @endif
                </a>
                <a class="btn btn-default btn-xs" href="{{URL::to("/viewUser/".$application->user->id)}}">
                    {{{$application->user->username}}} {{ trans('buttons.profile') }}
                </a>
            </td>
            
            @if (Auth::user()->userGroup == 1)
            <td>
                <a class="btn btn-warning btn-xs" href="{{URL::to("/editApplication/".$application->id)}}">
                    {{ trans('buttons.edit-application') }}
                </a>
                <a class="btn btn-danger btn-xs" href="{{URL::to("/deleteApplication/".$application->id)}}">
                    {{ trans('buttons.delete-application') }}
                </a>
            </td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>
</div>

<div>
    {{$applications->links()}} <!-- pagination links -->
</div>

@else

<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title">
            <b>{{ trans('content.no-one-applied-yet') }}</b>
        </div>
    </div>
</div>

@endif
     
@stop