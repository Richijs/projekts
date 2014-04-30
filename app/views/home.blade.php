@extends("layout")
@section("content")
<h2>Ze Website<small>yoaga</small></h2>
    
    <div>
        loremo upsumo, this is the home page!
        āē  strādā :)
        {{trans('validation.required')}} <-- test <!-- translation example -->
    </div>

    <h3>top 5 vacancies</h3>
    @foreach ($topVacancies as $vacancie)
    <div>
        <a href="/viewVacancie/{{{$vacancie->id}}}">{{{ $vacancie->name }}}</a>
        
        <b>created at:</b> {{{ date('d.m.y H:i',strtotime($vacancie->created_at)) }}}
                
        @if ($vacancie->poster)
             <img src="{{URL::to('/')}}/{{{$vacancie->poster}}}" width="50" height="50" alt="vacancie poster"/>
        @endif
            
        <b>Company:</b> {{{$vacancie->company}}}   

        <b> Added by: </b>
        
        <a href="/viewUser/{{{$vacancie->creator_id}}}">{{{ $vacancie->creatorName }}}</a>

        <b>___Applied for this Vacancie:</b> {{{$vacancie->applied}}}

    </div> 
    @endforeach
    
    <h3>top 5 employers</h3>
    
    @foreach ($topEmployers as $employer)
    <div>
        <b>{{{$employer->username}}}</b>
        
        {{{$employer->recommendations}}} <b>recommendations</b>
        
    </div>
    @endforeach
    
    
@stop