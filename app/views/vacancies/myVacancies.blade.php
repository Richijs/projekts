@extends("layout")
@section("content")

    <div class="page-header">
        <h1>
            Vacancies added by You, <small>{{{ Auth::user()->username }}}</small>
        </h1>
    </div>

    <div>
        @if (isset($vacancies))
        <div>
            You have added <b>{{{$vacancies->count}}}</b> vaccancies
        </div>
        
            @foreach ($vacancies as $vacancie)
            <div>
                <a href="/viewVacancie/{{{$vacancie->id}}}">{{{ $vacancie->name }}}</a>
                <span><b>created at:</b> {{{ date('d.m.y H:i',strtotime($vacancie->created_at)) }}}</span>

                <span>
                    <b>Company:</b> {{{$vacancie->company}}}   
                </span>
                
                @if ($vacancie->poster)
                <span>
                    <img src="{{URL::to('/')}}/{{{$vacancie->poster}}}" width="50" height="50" alt="vacancie poster"/>
                </span>
                @else
                <span>
                    <img src="{{URL::to('/')}}/uploads/vacanciePosters/default.jpeg" width="50" height="50" alt="vacancie poster"/>
                </span>
                @endif
                
                <span>
                    <a href="/viewApplicants/{{{$vacancie->id}}}">
                        <b>Applied for this Vacancie:</b>{{{$vacancie->applied}}}
                    </a>
                </span>
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