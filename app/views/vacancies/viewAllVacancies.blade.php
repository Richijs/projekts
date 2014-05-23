@extends("layout")
@section("content")
    
<div class="page-header">
    <h3>
        {{ trans('titles.vacancies') }}
    </h3>
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
            <th>{{ trans('content.added-by') }}</th>
            <th>{{ trans('content.created') }}</th>
            @if (Auth::check()) <th>{{ trans('content.actions') }}</th> @endif
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
                @if (Auth::check() && (Auth::user()->userGroup == 1 || $vacancie->creator_id==Auth::user()->id))
                    <a class="btn btn-default btn-xs" href="{{URL::to("/viewApplicants/".$vacancie->id)}}">
                        {{ trans('content.applied') }}: <b>{{{$vacancie->applied}}}</b>
                    </a>
                @else
                    {{ trans('content.applied') }}: <b>{{{$vacancie->applied}}}</b>
                @endif
            </td>
                    
            <td>
                <a href="{{URL::to("/viewUser/".$vacancie->creator_id)}}">{{{ $vacancie->creatorName }}}</a>
                
                @if (Auth::check() && $vacancie->creator_id!=Auth::user()->id)
                    <a class="btn btn-default btn-xs" href="{{URL::to("/recommend/".$vacancie->creator_id)}}">
                        @if ($vacancie->recommended)
                            {{{$vacancie->userRecommends}}}
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        @else
                            {{{$vacancie->userRecommends}}}
                            <span class="glyphicon glyphicon-thumbs-up"></span>
                        @endif
                    </a>
                @endif
            </td>
                    
            <td>
                {{{ date('d.m.y H:i',strtotime($vacancie->created_at)) }}}
            </td>
                    
            @if (Auth::check())
            <td>
                @if (Auth::user()->id!=$vacancie->creator_id)
                    <a class="btn btn-default btn-xs" href="{{{ URL::to("/sendMessage/".$vacancie->creator_id) }}}">{{ trans('forms.send-message') }}</a>
                @endif
                            
                @if ((Auth::user()->userGroup===1 || Auth::user()->userGroup===3) && $vacancie->creator_id!=Auth::user()->id)
                    <a class="btn btn-success btn-xs" href="{{URL::to("/apply/".$vacancie->id)}}">{{ trans('buttons.apply-vacancie') }}</a>
                @endif
                        
                @if (Auth::user()->userGroup == 1 || Auth::user()->id == $vacancie->creator_id)
                    <a class="btn btn-warning btn-xs" href="{{{ URL::to("/editVacancie/".$vacancie->id) }}}">{{ trans('buttons.edit-vacancie') }}</a>               
                    <a class="btn btn-danger btn-xs" href="{{{ URL::to("/deleteVacancie/".$vacancie->id) }}}">{{ trans('titles.delete-vacancie') }}</a>
                @endif
            </td>
            @endif         
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
            <b>{{ trans('content.no-vacancies-to-show') }}</b>
        </div>
    </div>
</div>

@endif

@stop