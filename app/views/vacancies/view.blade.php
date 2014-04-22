@extends("layout")
@section("content")
    <h2>Viewing vacancie</h2>
    <h3><a href="/viewVacancie/{{{$vacancie->id}}}">{{{ $vacancie->name }}}</a></h3>
    
    @if ($vacancie->poster)
        <div>
            <div>profile pic</div>
            <img src="{{URL::to('/')}}/{{{$vacancie->poster}}}" alt="vacancie poster"/>
        </div>
    @endif
    <div>
        {{{$vacancie->text}}}
    </div>
    <div>
        <b>Added at:</b> {{{$vacancie->created_at}}}
        <b>Added by:</b> {{{$vacancie->creatorName}}}
        
        <b>Last edit:</b> {{{$vacancie->updated_at}}}
    </div>
@stop