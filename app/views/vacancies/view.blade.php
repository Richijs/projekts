@extends("layout")
@section("content")

<span class="page-control btn-group btn-group-sm">
    @if (Auth::check())
        @if (Auth::user()->userGroup == 1 || Auth::user()->id == $vacancie->creator_id)
            <a class="btn btn-warning" href="{{{ URL::to("/editVacancie/".$vacancie->id) }}}">{{ trans('buttons.edit-vacancie') }}</a>               
            <a class="btn btn-danger" href="{{{ URL::to("/deleteVacancie/".$vacancie->id) }}}">{{ trans('titles.delete-vacancie') }}</a>
        @endif
        
        @if (Auth::user()->userGroup!=3)
            <a class="btn btn-default" href="{{{ URL::to("/myVacancies") }}}">{{ trans('buttons.my-vacancies') }}</a>
        @endif
        
    @endif
    <a class="btn btn-default" href="{{ URL::to("/viewAllVacancies")}}">{{ trans('buttons.all-vacancies') }}</a>
</span>

<div class="page-header">
    <h2>
        {{ trans('content.vacancie') }} 
        <div>
            <small>
                "<a href="{{URL::to("/viewVacancie/".$vacancie->id)}}">{{{ $vacancie->name }}}</a>"
            </small>
        </div>  
    </h2>
</div>

<ul class="list-group col-sm-offset-3 col-sm-6">
     
    <li class="list-group-item profileImg pull-right">
        <div>
            @if ($vacancie->poster)
                <img class="img-thumbnail" src="{{URL::to('/')}}/{{{$vacancie->poster}}}" width="200" alt="vacancie poster"/>
            @else
                <img class="img-thumbnail" src="{{URL::to('/')}}/uploads/vacanciePosters/default.jpeg" width="200" alt="vacancie poster"/>
            @endif     
        </div>
    </li>
    
    <li class="list-group-item pull-left">
        <div class="btn-group-vertical">
        @if (Auth::check())
                    
            @if ((Auth::user()->userGroup===1 || Auth::user()->userGroup===3) && $vacancie->creator_id!=Auth::user()->id)
                <a class="btn btn-success" href="{{URL::to("/apply/".$vacancie->id)}}">{{ trans('buttons.apply-vacancie') }}</a>
            @endif
            
            @if (Auth::user()->userGroup == 1 || Auth::user()->id == $vacancie->creator_id)
                <a class="btn btn-default" href="{{URL::to("/viewApplicants/".$vacancie->id)}}">
                    @if (Auth::user()->id == $vacancie->creator_id && isset($vacancie->new))
                        <span class="badge">{{ trans('content.new-applicants') }}</span>
                    @endif
                    {{ trans('content.applied') }}: <b>{{{$vacancie->applied}}}</b>
                </a>
            @else
                <a class="btn btn-default" disabled="disabled">{{ trans('content.applied') }}: <b>{{{$vacancie->applied}}}</b></a>
            @endif
            
            @if (Auth::user()->id != $vacancie->creator_id)
                <a class="btn btn-default" href="{{{ URL::to("/sendMessage/".$vacancie->creator_id) }}}">{{ trans('forms.send-message') }}</a>
            @endif
                        
        @else
            <a class="btn btn-default" disabled="disabled">{{ trans('content.applied') }}: <b>{{{$vacancie->applied}}}</b></a>
        @endif
        </div>
    </li>
    
    <div class="clearfix"></div>
    
    <li class="list-group-item well-item">
        <b>{{ trans('forms.text') }}:</b>
        <div class="newlineText well well-sm well-item-inside">{{{$vacancie->text}}}</div>
    </li>
    
    @if (isset($vacancie->company) && $vacancie->company!='')
    <li class="list-group-item">
        <b>{{ trans('forms.company-name') }}:</b> {{{$vacancie->company}}}
    </li>
    @endif
                        
    <li class="list-group-item">
        <b>{{ trans('forms.phone') }}:</b> <a href="tel:{{{$vacancie->phone}}}">{{{$vacancie->phone}}}</a>
    </li>
            
    <li class="list-group-item">
        <b> {{ trans('content.added-by') }}: </b>
        <a href="{{URL::to("/viewUser/".$vacancie->creator_id)}}">{{{ $vacancie->creatorName }}}</a>

        @if (Auth::check() && $vacancie->creator_id!=Auth::user()->id)
        <span>
            <a href="{{URL::to("/recommend/".$vacancie->creator_id)}}">
                <button class="btn btn-default btn-xs">
                    @if ($vacancie->recommended)
                        {{{$vacancie->userRecommends}}}
                        <span class="glyphicon glyphicon-remove-circle"></span>
                    @else
                        {{{$vacancie->userRecommends}}}
                        <span class="glyphicon glyphicon-thumbs-up"></span>
                    @endif
                </button>
            </a>
        </span>
        @endif
    </li>
            
    <li class="list-group-item">
        <b>{{ trans('content.created') }}:</b> {{{$vacancie->created_at}}}
    </li>

</ul>
        
@stop