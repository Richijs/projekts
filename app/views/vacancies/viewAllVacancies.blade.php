@extends("layout")
@section("content")
    
    <div class="page-header">
        <h1>
            All Vacancies
        </h1>
    </div>

    <div>
        @if (isset($vacancies))
            @foreach ($vacancies as $vacancie)
            <div class="media">
                @if ($vacancie->poster)
                <span class="pull-left">
                    <img class="media-object" src="{{URL::to('/')}}/{{{$vacancie->poster}}}" width="64" height="64" alt="vacancie poster"/>
                </span>
                @else
                <span class="pull-left">
                    <img class="media-object" src="{{URL::to('/')}}/uploads/vacanciePosters/default.jpeg" width="64" height="64" alt="vacancie poster"/>
                </span>
                @endif
                <!-- else - shows default vacancie pic -->
                <div class="media-body">
                    <h4 class="media-heading">
                        <a href="/viewVacancie/{{{$vacancie->id}}}">{{{ $vacancie->name }}}</a>
                    </h4>
                    
                    <div>                   
                        <b>created at:</b> {{{ date('d.m.y H:i',strtotime($vacancie->created_at)) }}}
                    
                        <b>Company:</b> {{{$vacancie->company}}}   
                    </div>
                
                    
                        <b> Added by: </b>
                        <a href="/viewUser/{{{$vacancie->creator_id}}}">{{{ $vacancie->creatorName }}}</a>
                        <a href="/viewRecommenders/{{{$vacancie->creator_id}}}">({{{$vacancie->userRecommends}}})</a>
                    
                    @if (Auth::check() && $vacancie->creator_id!=Auth::user()->id)
                    
                        <a class="btn btn-default" href="/recommend/{{{$vacancie->creator_id}}}">
                            @if ($vacancie->recommended)
                                <span class="glyphicon glyphicon-remove-circle"></span>
                                <span class="glyphicon glyphicon-thumbs-up"></span>
                            @else
                                <span class="glyphicon glyphicon-thumbs-up"></span>
                            @endif
                        </a>
                   
                    @endif
                        
                    
                        <b>Applied for this Vacancie:</b> {{{$vacancie->applied}}}
                   
                    
                </div>
            </div>
            @endforeach
            
            
            <div>
                {{$vacancies->links()}} <!-- pagination links -->
            </div>
        @else
            <div>No Vacancies to show</div>
        @endif
    </div>
@stop