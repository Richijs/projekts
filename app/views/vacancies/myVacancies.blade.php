@extends("layout")
@section("content")
    <h2>Vacancies added by You, {{{ Auth::user()->username }}}</h2>
    <div>
        @if (isset($vacancies))
        <div>
            You have added <b>{{{$vacancies->count}}}</b> vaccancies
        </div>
        
            @foreach ($vacancies as $vacancie)
            <div>
                <a href="/viewVacancie/{{{$vacancie->id}}}">{{{ $vacancie->name }}}</a>
                <span><b>created at:</b> {{{ date('d.m.y H:i',strtotime($vacancie->created_at)) }}}</span>
                
                @if ($vacancie->poster)
                <span>
                    <img src="{{URL::to('/')}}/{{{$vacancie->poster}}}" width="50" height="50" alt="vacancie poster"/>
                </span>
                @endif
                
            </div>
            @endforeach
            <div>
                {{$vacancies->links()}} <!-- pagination links -->
            </div>
        @else
            <div>You have'nt added any vacancies</div>
        @endif
    </div>
@stop