@extends("layout")
@section("content")

    <div class="page-header">
        <h1>
            Viewing vacancie
        </h1>
    </div>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">
            <b>Vacancie: </b>
            <a href="{{URL::to("/viewVacancie/".$vacancie->id)}}">{{{ $vacancie->name }}}</a>
        </div>
    </div>

    <div class="panel-body">
        <div class="btn-group-vertical col-sm-5">
                        
        @if (Auth::check())
                    
            @if ((Auth::user()->userGroup===1 || Auth::user()->userGroup===3) && $vacancie->creator_id!=Auth::user()->id)
                <a class="btn btn-success" href="{{URL::to("/apply/".$vacancie->id)}}">Apply this vacancie</a>
            @endif
            
            @if (Auth::user()->userGroup == 1 || Auth::user()->id == $vacancie->creator_id)
                <a class="btn btn-default" href="{{URL::to("/viewApplicants/".$vacancie->id)}}">Applied for this Vacancie: <b>{{{$vacancie->applied}}}</b></a>
                <a class="btn btn-warning" href="{{{ URL::to("/editVacancie/".$vacancie->id) }}}">Edit Vacancie</a>               
                <a class="btn btn-danger" href="{{{ URL::to("/deleteVacancie/".$vacancie->id) }}}">Delete Vacancie</a>
            @endif
    
        @else
            <a class="btn btn-default">Applied for this Vacancie: <b>{{{$vacancie->applied}}}</b></a>
        @endif
        
            <div class="pull-right">
                <b>Poster:</b>
                @if ($vacancie->poster)
                <img src="{{URL::to('/')}}/{{{$vacancie->poster}}}" width="200" alt="vacancie poster"/>
                @else
                <img src="{{URL::to('/')}}/uploads/vacanciePosters/default.jpeg" width="200" alt="vacancie poster"/>
                @endif
            </div>
        
        </div>
        
        <ul class="list-group col-sm-5">
            <li class="list-group-item">
                <b>Text:</b>
                <div class="newlineText well well-sm">{{{$vacancie->text}}}</div>
            </li>
            
            <li class="list-group-item">
                <b>Company:</b> {{{$vacancie->company}}}
            </li>
            
            <li class="list-group-item">
                <b>Phone:</b> <a href="tel:{{{$vacancie->phone}}}">{{{$vacancie->phone}}}</a>
            </li>
            
            <li class="list-group-item">
                <b> Added by: </b>
                    <a href="{{URL::to("/viewUser/".$vacancie->creator_id)}}">{{{ $vacancie->creatorName }}}</a>

                @if (Auth::check() && $vacancie->creator_id!=Auth::user()->id)
                <span>
                    <a href="{{URL::to("/recommend/".$vacancie->creator_id)}}">
                        <button class="btn btn-default">
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
                <b>Added:</b> {{{$vacancie->created_at}}}
            </li>
            
        </ul>
        
        
    </div>
</div>    
    
@stop