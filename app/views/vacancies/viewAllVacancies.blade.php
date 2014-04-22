@extends("layout")
@section("content")
    <h2>All Vacancies</h2>
    <div>
        @if (isset($vacancies))
            @foreach ($vacancies as $vacancie)
            <div>
                <a href="/viewVacancie/{{{$vacancie->id}}}">{{{ $vacancie->name }}}</a>
                <span>created at {{{ date('d.m.y H:i',strtotime($vacancie->created_at)) }}}</span>
                
                @if ($vacancie->poster)
                <span>
                    <!--<img src="{{URL::to('/')}}/{{{$user->picture}}}" width="50" height="50" alt="user picture"/>-->
                </span>
                @endif
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