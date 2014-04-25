@extends("layout")
@section("content")
    <h2>Ze Website</h2>
    <div>loremo upsumo, this is the home page!</div>
    <div>āē  strādā :)</div>
    {{trans('validation.required')}} <-- test <!-- translation example -->
    
    <h3>top 5 vacancies</h3>
    @foreach ($topVacancies as $vacancie)
    <div>
        <a href="/viewVacancie/{{{$vacancie->id}}}">{{{ $vacancie->name }}}</a>
        <span><b>created at:</b> {{{ date('d.m.y H:i',strtotime($vacancie->created_at)) }}}</span>
                
                @if ($vacancie->poster)
                <span>
                    <img src="{{URL::to('/')}}/{{{$vacancie->poster}}}" width="50" height="50" alt="vacancie poster"/>
                </span>
                @endif
                
        <span>
                    <b> Added by: </b>
                    <a href="/viewUser/{{{$vacancie->creator_id}}}">{{{ $vacancie->creatorName }}}</a>
        </span>
        <span>
                    <b>___Applied for this Vacancie:</b> {{{$vacancie->applied}}}
        </span>
    </div> 
    @endforeach
    
    
@stop