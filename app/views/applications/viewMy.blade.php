@extends("layout")
@section("content")
    
    <span class="page-control btn-group btn-group-sm">
        <a class="btn btn-default" href="{{URL::to("/viewAllVacancies")}}">{{ trans('buttons.all-vacancies') }}</a>
    </span>

    <div class="page-header">
        <h2>{{ trans('titles.you-have-applied') }} 
                @if (isset($applications))
                    {{{$applications->count}}}
                @endif
            {{ trans('titles.vacancies') }},
            <small>{{{ Auth::user()->username }}}</small>
        </h2>
    </div>
    

@if (isset($applications))

        
<div class='table-responsive'>
<table class='table'>
    <thead>
        <tr>
            <th>{{ trans('content.vacancie') }}</th>
            <th>{{ trans('content.applied-at') }}</th>
            <th>{{ trans('content.view') }}</th>
            <th>{{ trans('content.controls') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($applications as $application)
        <tr>
            <td>
                <a href="{{URL::to("/viewVacancie/".$application->vacancieId)}}">
                    {{{ $application->vacancieName }}}
                </a>
            </td>
                    
            <td>
                {{{ date('d.m.y H:i',strtotime($application->created_at)) }}}
            </td>
                    
            <td>
                <a class="btn btn-default btn-xs" href="{{URL::to("/viewApplication/".$application->id)}}">{{ trans('buttons.view-your-application') }}</a>
            </td>
                    
            <td>
                <a class="btn btn-warning btn-xs" href="{{URL::to("/editApplication/".$application->id)}}">{{ trans('buttons.edit-application') }}</a>
                <a class="btn btn-danger btn-xs" href="{{URL::to("/deleteApplication/".$application->id)}}">{{ trans('buttons.delete-application') }}</a>
            </td>
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
            <b>{{ trans('content.havent-applied-any-vacancies') }}</b>
        </div>
    </div>
</div>

@endif

@stop