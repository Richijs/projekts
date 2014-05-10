@extends("layout")
@section("content")

<div class="page-header">
    <h1>Ze Website<small>yoaga</small></h1>
</div>   
    
    <div>
        loremo upsumo, this is the home page!
        āē  strādā :)
        {{trans('validation.required')}} <-- test <!-- translation example -->
    </div>






<div class="container-fluid">
    
    <div class="row">
        <div id="carousel-example-generic" class="carousel slide col-sm-6 col-sm-offset-2" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner">
    <div class="item active">
      <img src="{{URL::to('/')}}/uploads/vacanciePosters/default.jpeg" alt="...">
      <div class="carousel-caption">
          <h4>smth smth</h4>
          <p>yo yo yo</p>
      </div>
    </div>
    <div class="item">
      <img src="{{URL::to('/')}}/uploads/vacanciePosters/default.jpeg" alt="...">
      <div class="carousel-caption">
          <h4>smth smth</h4>
          <a href="#"> saggs </a>
          <p>yo yo yo</p>
      </div>
    </div>

  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
    <!--<span class="glyphicon glyphicon-chevron-left"></span>-->
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
    <!--<span class="glyphicon glyphicon-chevron-right"></span>-->
  </a>
</div>
  
    </div>
    
    
    <div class="row">
        
        <div class="col-sm-7">
    <h3>top 5 vacancies</h3>
    @foreach ($topVacancies as $vacancie)
    <div>
        @if ($vacancie->poster)
             <img src="{{URL::to('/')}}/{{{$vacancie->poster}}}" width="50" height="50" alt="vacancie poster"/>
        @else
             <img src="{{URL::to('/')}}/uploads/vacanciePosters/default.jpeg" width="50" height="50" alt="vacancie poster"/>
        @endif
        
        <a href="/viewVacancie/{{{$vacancie->id}}}">{{{ $vacancie->name }}}</a>
        
        <b>created at:</b> {{{ date('d.m.y H:i',strtotime($vacancie->created_at)) }}}
            
        <b>Company:</b> {{{$vacancie->company}}}   

        <b> Added by: </b>
        
        <a href="/viewUser/{{{$vacancie->creator_id}}}">{{{ $vacancie->creatorName }}}</a>

        <b>___Applied for this Vacancie:</b> {{{$vacancie->applied}}}

    </div> 
    @endforeach
        </div>
    
        
        <div class="col-sm-5">
    <h3>top 5 employers</h3>
    @foreach ($topEmployers as $employer)
    <div>
        @if ($employer->picture)
             <img src="{{URL::to('/')}}/{{{$employer->picture}}}" width="50" height="50" alt="employer picture"/>
        @else
             <img src="{{URL::to('/')}}/uploads/profileImages/default.jpeg" width="50" height="50" alt="employer picture"/>
        @endif
        
        <a href="/viewUser/{{{$employer->id}}}"><b>{{{$employer->username}}}</b></a>
        
        {{{$employer->recommendations}}} <b>recommendations</b>
        
    </div>
    @endforeach
        </div>
    
    
    
    </div>
    
</div>
    


    
    
    
@stop