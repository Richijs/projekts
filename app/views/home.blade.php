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
  
        
        <div class="col-sm-6">
            Shake treat bag behind the couch but swat at dog yet hide when guests come over. Make muffins destroy couch shake treat bag so inspect anything brought into the house make muffins yet under the bed. Swat at dog stand in front of the computer screen or rub face on everything. Sleep on keyboard. Need to chase tail stand in front of the computer screen for chase mice, attack feet. Sleep on keyboard run in circles for behind the couch. Swat at dog chew iPad power cord stand in front of the computer screen sun bathe. Under the bed. Stick butt in face swat at dog. Chew foot. Chew foot. Chew foot stick butt in face or cat snacks. Chase mice chase mice. Sun bathe sweet beast or sun bathe sweet beast for attack feet. Chase mice stand in front of the computer screen intently stare at the same spot for use lap as chair. Sweet beast hate dog and cat snacks and hate dog but stand in front of the computer screen hunt anything that moves burrow under covers. Sun bathe sweet beast. Sun bathe mark territory so mark territory. 

All of a sudden go crazy flop over. Hate dog lick butt yet shake treat bag all of a sudden go crazy hopped up on goofballs but make muffins. Chew iPad power cord hate dog cat snacks intrigued by the shower. Find something else more interesting leave dead animals as gifts all of a sudden go crazy. Leave dead animals as gifts play time all of a sudden go crazy under the bed or lick butt. Destroy couch. Sleep on keyboard intrigued by the shower, so attack feet. 

Hide when guests come over swat at dog or hopped up on goofballs, stick butt in face, or stand in front of the computer screen, swat at dog use lap as chair. Chew foot sweet beast, missing until dinner time. Inspect anything brought into the house all of a sudden go crazy. Make muffins. Claw drapes hide when guests come over. Stare at ceiling missing until dinner time and stand in front of the computer screen or chew iPad power cord yet all of a sudden go crazy, but sweet beast. Find something else more interesting stretch sweet beast, flop over yet need to chase tail. Hunt anything that moves chase imaginary bugs missing until dinner time chew foot for chew iPad power cord so chase mice stretch. Sweet beast. Throwup on your pillow claw drapes flop over all of a sudden go crazy or under the bed and claw drapes but rub face on everything. Chase mice play time play time or flop over. Destroy couch make muffins. Intrigued by the shower claw drapes chew iPad power cord claw drapes yet all of a sudden go crazy give attitude, so burrow under covers. Inspect anything brought into the house sun bathe yet stare at ceiling and shake treat bag. Attack feet flop over find something else more interesting so why must they do that. Climb leg run in circles, for need to chase tail inspect anything brought into the house need to chase tail. Make muffins burrow under covers all of a sudden go crazy inspect anything brought into the house. Behind the couch missing until dinner time so all of a sudden go crazy, missing until dinner time need to chase tail for under the bed intently sniff hand. 

Stare at ceiling stand in front of the computer screen. Play time chase imaginary bugs. Destroy couch hate dog but rub face on everything. Burrow under covers hopped up on goofballs stick butt in face so rub face on everything. Hide when guests come over hunt anything that moves and destroy couch. Cat snacks. Hate dog. Under the bed need to chase tail. Run in circles. Chew iPad power cord need to chase tail. Stretch. Intently stare at the same spot. Cat snacks cat snacks. Stretch. Leave dead animals as gifts lick butt hopped up on goofballs. Chew foot rub face on everything, stand in front of the computer screen hide when guests come over. Cat snacks shake treat bag and hide when guests come over lick butt, hopped up on goofballs. Claw drapes stare at ceiling so mark territory sweet beast. Chase imaginary bugs hide when guests come over. Find something else more interesting chew iPad power cord for intrigued by the shower sun bathe or hopped up on goofballs so chase mice so sleep on keyboard. Flop over chase mice. Chew foot burrow under covers swat at dog so flop over but chew iPad power cord so sun bathe but throwup on your pillow. 

        </div>  
        
        
        
    </div>
    
    
    <div class="row">
        
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