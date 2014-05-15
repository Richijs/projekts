@extends("layout")
@section("content")

    <div class="page-header">
        <h1>
            Viewing vacancie <small><a href="/viewVacancie/{{{$vacancie->id}}}">{{{ $vacancie->name }}}</a></small>
        </h1>
    </div>


    @if ($vacancie->poster)
            <img src="{{URL::to('/')}}/{{{$vacancie->poster}}}" width="200" alt="vacancie poster"/>
    @else
             <img src="{{URL::to('/')}}/uploads/vacanciePosters/default.jpeg" width="200" alt="vacancie poster"/>
    @endif

            <b>Company:</b> {{{$vacancie->company}}}   

    <div style="white-space:pre-line;">
       {{{$vacancie->text}}}
    </div>

        <b>Applied for this Vacancie:</b> {{{$vacancie->applied}}}


                    <b> Added by: </b>
                    <a href="/viewUser/{{{$vacancie->creator_id}}}">{{{ $vacancie->creatorName }}}</a>
                    
                    <a href="/viewRecommenders/{{{$vacancie->creator_id}}}">({{{$vacancie->userRecommends}}})</a>

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

        <b>Added at:</b> {{{$vacancie->created_at}}} 
        

                
    @if (Auth::check() && (Auth::user()->userGroup===1 || Auth::user()->userGroup===3) && $vacancie->creator_id!=Auth::user()->id)
        <a href="/apply/{{{$vacancie->id}}}">Apply this vacancie</a>
    @endif
    
    
    
    
    
@stop