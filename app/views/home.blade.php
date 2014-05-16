@extends("layout")
@section("content")

<div class="page-header">
    <h1>Ze Website <small>offer or find jobs</small></h1>
</div>   
    
  

<div class="container-fluid">
    
    <div class="row">
        <div id="carousel-example-generic" class="carousel slide col-sm-4" data-ride="carousel">
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
  
        <div class="col-sm-8">
            
    <div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">
            Top 5 Vacancies
        </div>
    </div>
    <div class="panel-body">
    @foreach ($topVacancies as $vacancie)
    <div>
        @if ($vacancie->poster)
             <img src="{{URL::to('/')}}/{{{$vacancie->poster}}}" width="50" height="50" alt="vacancie poster"/>
        @else
             <img src="{{URL::to('/')}}/uploads/vacanciePosters/default.jpeg" width="50" height="50" alt="vacancie poster"/>
        @endif
        
        <a href="{{ URL::to("/viewVacancie/".$vacancie->id)}}">{{{ $vacancie->name }}}</a>
        
        <b>created at:</b> {{{ date('d.m.y H:i',strtotime($vacancie->created_at)) }}}
            
        <b>Company:</b> {{{$vacancie->company}}}   

        <b> Added by: </b>
        
        <a href="{{ URL::to("/viewUser/".$vacancie->creator_id)}}">{{{ $vacancie->creatorName }}}</a>

        <b>___Applied for this Vacancie:</b> {{{$vacancie->applied}}}

    </div> 
    @endforeach
    
        </div>
    </div>
        </div>
         
        
        
        
    </div>
    
    
    <div class="row">
        
        <div class="col-sm-8">
            Shake treat bag behind the couch but swat at dog yet hide when guests come over. Make muffins destroy couch shake treat bag so inspect anything brought into the house make muffins yet under the bed. Swat at dog stand in front of the computer screen or rub face on everything. Sleep on keyboard. Need to chase tail stand in front of the computer screen for chase mice, attack feet. Sleep on keyboard run in circles for behind the couch. Swat at dog chew iPad power cord stand in front of the computer screen sun bathe. Under the bed. Stick butt in face swat at dog. Chew foot. Chew foot. Chew foot stick butt in face or cat snacks. Chase mice chase mice. Sun bathe sweet beast or sun bathe sweet beast for attack feet. Chase mice stand in front of the computer screen intently stare at the same spot for use lap as chair. Sweet beast hate dog and cat snacks and hate dog but stand in front of the computer screen hunt anything that moves burrow under covers. Sun bathe sweet beast. Sun bathe mark territory so mark territory. 

All of a sudden go crazy flop over. Hate dog lick butt yet shake treat bag all of a sudden go crazy hopped up on goofballs but make muffins. Chew iPad power cord hate dog cat snacks intrigued by the shower. Find something else more interesting leave dead animals as gifts all of a sudden go crazy. Leave dead animals as gifts play time all of a sudden go crazy under the bed or lick butt. Destroy couch. Sleep on keyboard intrigued by the shower, so attack feet. 

        </div> 
    
        
        <div class="col-sm-4">
            
    <div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">
            Top 5 Employers
        </div>
    </div>
    <div class="panel-body">
    @foreach ($topEmployers as $employer)
    <div>
        @if ($employer->picture)
             <img src="{{URL::to('/')}}/{{{$employer->picture}}}" width="50" height="50" alt="employer picture"/>
        @else
             <img src="{{URL::to('/')}}/uploads/profileImages/default.jpeg" width="50" height="50" alt="employer picture"/>
        @endif
        
        <a href="{{ URL::to("/viewUser/".$employer->id)}}"><b>{{{$employer->username}}}</b></a>
        
        {{{$employer->recommendations}}} <b>recommendations</b>
        
    </div>
    @endforeach
        </div>
    </div>
        </div>
    
    
    </div>
    
</div>
    


    
    
    
@stop