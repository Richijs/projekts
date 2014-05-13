@extends("layout")
@section("content")

    <div class="page-header">
        <h1>
            Viewing vacancie <small><a href="/viewVacancie/{{{$vacancie->id}}}">{{{ $vacancie->name }}}</a></small>
        </h1>
    </div>


    @if ($vacancie->poster)
        <div>
            <img src="{{URL::to('/')}}/{{{$vacancie->poster}}}" width="100" alt="vacancie poster"/>
        </div>
    @else
        <div>
             <img src="{{URL::to('/')}}/uploads/vacanciePosters/default.jpeg" width="100" alt="vacancie poster"/>
        </div>
    @endif
    <div>
            <b>Company:</b> {{{$vacancie->company}}}   
    </div>
    <div style="white-space:pre-line;">
       {{{$vacancie->text}}}
    </div>
    <div>
        <b>Applied for this Vacancie:</b> {{{$vacancie->applied}}}
    </div>
    <span>
                    <b> Added by: </b>
                    <a href="/viewUser/{{{$vacancie->creator_id}}}">{{{ $vacancie->creatorName }}}</a>
                    <a href="/viewRecommenders/{{{$vacancie->creator_id}}}">({{{$vacancie->userRecommends}}})</a>
                </span>
                @if (Auth::check() && $vacancie->creator_id!=Auth::user()->id)
                <span>
                    <a href="/recommend/{{{$vacancie->creator_id}}}">
                        <button class="btn btn-default">
                            @if ($vacancie->recommended)
                                <span class="glyphicon glyphicon-remove-circle"></span>
                                <span class="glyphicon glyphicon-thumbs-up"></span>
                            @else
                                <span class="glyphicon glyphicon-thumbs-up"></span>
                            @endif
                        </button>
                    </a>
                </span>
                @endif
    <div>
        <b>Added at:</b> {{{$vacancie->created_at}}}        
        <b>Last edit:</b> {{{$vacancie->updated_at}}}
    </div>
    @if (Auth::check() && (Auth::user()->userGroup===1 || Auth::user()->userGroup===3))
        <a href="/apply/{{{$vacancie->id}}}">Apply this vacancie</a>
    @endif
@stop