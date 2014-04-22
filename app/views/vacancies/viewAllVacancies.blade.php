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
                    <!-- <img src="{{URL::to('/')}}/{{{$vacancie->poster}}}" width="50" height="50" alt="vacancie poster"/> -->
                </span>
                @endif
                
                <span>
                    <b> Added by: </b>
                    <a href="/viewUser/{{{$vacancie->creator_id}}}">{{{ $vacancie->creatorName }}}</a>
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