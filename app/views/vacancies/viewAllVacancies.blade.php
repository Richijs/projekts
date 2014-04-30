@extends("layout")
@section("content")
    <h2>All Vacancies</h2>
    <div>
        @if (isset($vacancies))
            @foreach ($vacancies as $vacancie)
            <div>
                <a href="/viewVacancie/{{{$vacancie->id}}}">{{{ $vacancie->name }}}</a>
                <span><b>created at:</b> {{{ date('d.m.y H:i',strtotime($vacancie->created_at)) }}}</span>
                
                @if ($vacancie->poster)
                <span>
                    <img src="{{URL::to('/')}}/{{{$vacancie->poster}}}" width="50" height="50" alt="vacancie poster"/>
                </span>
                @endif
                
                <span>
                    <b>Company:</b> {{{$vacancie->company}}}   
                </span>
                
                <span>
                    <b> Added by: </b>
                    <a href="/viewUser/{{{$vacancie->creator_id}}}">{{{ $vacancie->creatorName }}}</a>
                    <a href="/viewRecommenders/{{{$vacancie->creator_id}}}">({{{$vacancie->userRecommends}}})</a>
                </span>
                @if (Auth::check() && $vacancie->creator_id!=Auth::user()->id)
                <span>
                    <a href="/recommend/{{{$vacancie->creator_id}}}">
                        @if ($vacancie->recommended)
                            <span class="glyphicon glyphicon-remove-circle"></span>
                            <span class="glyphicon glyphicon-thumbs-up"></span>
                        @else
                            <span class="glyphicon glyphicon-thumbs-up"></span>
                        @endif
                    </a>
                </span>
                @endif
                <span>
                    <b>___Applied for this Vacancie:</b> {{{$vacancie->applied}}}
                </span>
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