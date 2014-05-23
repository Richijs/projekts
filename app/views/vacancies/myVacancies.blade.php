@extends("layout")
@section("content")

    <span class="page-control btn-group btn-group-sm">
        <a class="btn btn-default" href="{{ URL::to("/viewAllVacancies")}}">{{ trans('buttons.all-vacancies') }}</a>
    </span>

    <div class="page-header">
        <h2>
            {{ trans('titles.your-added-vacancies') }}
                @if (isset($vacancies))
                    (<b>{{{$vacancies->count}}}</b>)
                @endif
            , 
            <small>{{{ Auth::user()->username }}}</small>
        </h2>
    </div>

@if (isset($vacancies))
        
<div class='table-responsive'>
<table class='table'>
    <thead>
        <tr>
            <th>{{ trans('content.vacancie') }}</th>
            <th>{{ trans('forms.company-name') }}</th>
            <th>{{ trans('forms.poster') }}</th>
            <th>{{ trans('content.applicants') }}</th>
            <th>{{ trans('content.created') }}</th>
            <th>{{ trans('content.actions') }}</th>
        </tr>
    </thead>
    <tbody>

    @foreach ($vacancies as $vacancie)
        <tr>
            <td>
                <a href="{{URL::to("/viewVacancie/".$vacancie->id)}}">{{{ $vacancie->name }}}</a>
            </td>
                
            <td>
                {{{$vacancie->company}}} 
            </td>
                
            <td>
                @if ($vacancie->poster)
                    <img src="{{URL::to('/')}}/{{{$vacancie->poster}}}" width="36" height="36" alt="vacancie poster"/>
                @else
                    <img src="{{URL::to('/')}}/uploads/vacanciePosters/default.jpeg" width="36" height="36" alt="vacancie poster"/>
                @endif
            </td>
                        
            <td>
                <a class="btn btn-default btn-xs" href="{{URL::to("/viewApplicants/".$vacancie->id)}}">
                    @if (isset($vacancie->new))
                        <span class="badge">{{ trans('content.new-applicants') }}</span>
                    @endif
                        {{ trans('content.applied') }}: <b>{{{$vacancie->applied}}}</b>
                </a>
            </td>
                
            <td>
                {{{ date('d.m.y H:i',strtotime($vacancie->created_at)) }}}
            </td>
                
            <td>
                <a class="btn btn-warning btn-xs" href="{{URL::to("/editVacancie/".$vacancie->id)}}">{{ trans('buttons.edit-vacancie') }}</a>
                <a class="btn btn-danger btn-xs" href="{{URL::to("/deleteVacancie/".$vacancie->id)}}">{{ trans('titles.delete-vacancie') }}</a>
            </td>

        </tr>
    @endforeach
    </tbody>
</table>
</div>

        
<div>
    {{$vacancies->links()}} <!-- pagination links -->
</div>

@else

<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title">
            <b>{{ trans('content.you-havent-added-any-vacancies') }}</b>
        </div>
    </div>
</div>
        
@endif

@stop