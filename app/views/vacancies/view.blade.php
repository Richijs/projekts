@extends("layout")
@section("content")
    <h2>Viewing vacancie</h2>
    <h3><a href="/viewVacancie/{{{$vacancie->id}}}">{{{ $vacancie->name }}}</a></h3>
    
    @if ($vacancie->poster)
        <div>
            <img src="{{URL::to('/')}}/{{{$vacancie->poster}}}" alt="vacancie poster"/>
        </div>
    @endif
    <div>
        {{{$vacancie->text}}}
    </div>
    <div>
        <b>Applied for this Vacancie:</b> {{{$vacancie->applied}}}
    </div>
    <div>
        <b>Added at:</b> {{{$vacancie->created_at}}}
        <b>Added by:</b> {{{$vacancie->creatorName}}}
        
        <b>Last edit:</b> {{{$vacancie->updated_at}}}
    </div>
    @if (Auth::check() && (Auth::user()->userGroup===1 || Auth::user()->userGroup===3))
        <a href="/apply/{{{$vacancie->id}}}">Apply this vacancie</a>
    @endif
@stop