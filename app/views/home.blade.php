@extends("layout")
@section("content")

<div class="page-header">
    <h2>{{ trans('titles.site-title') }}</h2>
</div>   
    
<div class="container-fluid">
    <div class="row">
        <h3 class="col-sm-offset-1 col-sm-10 top-title">Top Vacancies</h3>
        
        <div id="carousel-generic" class="carousel slide col-sm-offset-1 col-sm-4" data-ride="carousel">
                        
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#carousel-generic" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-generic" data-slide-to="1"></li>
                <li data-target="#carousel-generic" data-slide-to="2"></li>
                <li data-target="#carousel-generic" data-slide-to="3"></li>
                <li data-target="#carousel-generic" data-slide-to="4"></li>
                <li data-target="#carousel-generic" data-slide-to="5"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                <div class="item active">
                    <img src="{{URL::to('/')}}/uploads/profileImages/default.jpeg" alt="employer picture"/>
                    <div class="carousel-caption">
                        <div class="inner-cap">
                            <a href="{{ URL::route("vacancies/viewAllVacancies") }}">
                                <h4 class="first-caption">Dont miss the best vacancies!</h4>
                            </a>
                        </div>
                    </div>
                </div>
                
                @foreach ($topVacancies as $vacancie)
                <div class="item">
                    @if ($vacancie->poster)
                        <img src="{{URL::to('/')}}/{{{$vacancie->poster}}}" alt="vacancie poster"/>
                    @else
                        <img src="{{URL::to('/')}}/uploads/vacanciePosters/default.jpeg" alt="vacancie poster"/>
                    @endif
                    
                    <div class="carousel-caption">
                        <div class="inner-cap">
                        <h4><a href="{{ URL::to("/viewVacancie/".$vacancie->id)}}">{{{ $vacancie->name }}}</a></h4>
                        <p>
                            @if (Auth::check() && (Auth::user()->userGroup == 1 || $vacancie->creator_id==Auth::user()->id))
                                <a class="btn btn-default btn-xs pull-right" href="{{URL::to("/viewApplicants/".$vacancie->id)}}">
                                    Applied: <b>{{{$vacancie->applied}}}</b>
                                </a>
                            @else
                                <span class="pull-right">
                                    Applied: <b>{{{$vacancie->applied}}}</b>
                            </span>
                            @endif
                        </p>
                        </div>
                    </div>
                </div>
                @endforeach
                
            </div>

            <!-- Controls -->
            <a class="left carousel-control" href="#carousel-generic" data-slide="prev"></a>
            <a class="right carousel-control" href="#carousel-generic" data-slide="next"></a>
  
        </div>
  
        
            
          
        <ul class="list-group col-sm-6">
    @foreach ($topVacancies as $vacancie)
    <li class="list-group-item front-list-item">
        @if ($vacancie->poster)
             <img src="{{URL::to('/')}}/{{{$vacancie->poster}}}" width="36" height="36" alt="vacancie poster"/>
        @else
             <img src="{{URL::to('/')}}/uploads/vacanciePosters/default.jpeg" width="36" height="36" alt="vacancie poster"/>
        @endif
        
        <a href="{{ URL::to("/viewVacancie/".$vacancie->id)}}">{{{ $vacancie->name }}}</a>
            
        @if (Auth::check() && (Auth::user()->userGroup == 1 || $vacancie->creator_id==Auth::user()->id))
        <a class="btn btn-default btn-xs pull-right" href="{{URL::to("/viewApplicants/".$vacancie->id)}}">
            Applied: <b>{{{$vacancie->applied}}}</b>
        </a>
        @else
        <span class="pull-right">
            Applied: <b>{{{$vacancie->applied}}}</b>
        </span>
        @endif
    </li>
    <div class="clearfix"></div>
    @endforeach
    </ul>
    
  
        
    </div>
    
    <div class="row">


            
    
            <h3 class="col-sm-offset-3 col-sm-6 top-title">Top Employers</h3>
        <ul class="list-group col-sm-offset-3 col-sm-6">
    @foreach ($topEmployers as $employer)
    <li class="list-group-item front-list-item">
        @if ($employer->picture)
             <img src="{{URL::to('/')}}/{{{$employer->picture}}}" width="36" height="36" alt="employer picture"/>
        @else
             <img src="{{URL::to('/')}}/uploads/profileImages/default.jpeg" width="36" height="36" alt="employer picture"/>
        @endif
        
        @if (Auth::check())
        <a href="{{ URL::to("/viewUser/".$employer->id)}}"><b>{{{$employer->username}}}</b></a>
        @else
        <b>{{{$employer->username}}}</b>
        @endif
        
        
        @if (Auth::check())
        <a class="btn btn-default btn-xs pull-right" href="{{URL::to("/viewRecommenders/".$employer->id)}}">
            <b>{{{$employer->recommendations}}}</b> recommenders
        </a>
        @else
        <span class="pull-right">
            <b>{{{$employer->recommendations}}}</b> recommenders
        </span>
        @endif
     </li>
     <div class="clearfix"></div>
    @endforeach
        </ul>
     </div>
        
    </div>
    
        
</div>
    


    
    
    
@stop