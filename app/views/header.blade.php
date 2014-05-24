@section("header")
    <div class="header">
        <div class="container">
            <div class="site-title col-sm-11">
                <h1 class="title-text">{{ trans('titles.site-title') }}</h1>
            </div>     
            
            <div class="lang btn-group btn-toggle">
                <a href="{{ URL::to("/lang/lv") }}" class="btn btn-xs btn-default
                    @if (Config::get('app.locale')=='lv') btn-primary active @endif">
                    LV
                </a>
                <a href="{{ URL::to("/lang/en") }}" class="btn btn-xs btn-default
                    @if (Config::get('app.locale')=='en') btn-primary active @endif">
                    EN
                </a>
            </div> 
            
            <nav class="navbar" role="navigation">
                <ul class="nav navbar-nav nav-pills nav-stacked">
                    <li {{ Request::is('/') ? 'class="active"' : '' }}>
                        <a href="{{ URL::route("home") }}">{{ trans('titles.home') }}</a
                    </li>
                    <li {{ Request::is('viewAllVacancies') ? 'class="active"' : '' }}>
                        <a href="{{ URL::route("vacancies/viewAllVacancies") }}">{{ trans('titles.vacancies') }}</a>
                    </li>
                    <li {{ Request::is('about') ? 'class="active"' : '' }}>
                        <a href="{{ URL::to("/about") }}">{{ trans('titles.about') }}</a>
                    </li>
                    <li {{ Request::is('contactAdmin') ? 'class="active"' : '' }}>
                        <a href="{{ URL::route("messaging/contact") }}">{{ trans('titles.contact-admin') }}</a>
                    </li>
                        
                @if (Auth::check())
                    <li {{ Request::is('viewAllUsers') ? 'class="active"' : '' }}>
                        <a href="{{ URL::route("users/viewAllUsers") }}">Site Users</a>
                    </li>
                    <li {{ Request::is('viewUser/'.Auth::user()->id) ? 'class="active"' : '' }}>
                        <a href="{{ URL::to("/viewUser/".Auth::user()->id) }}">
                            <span class="loggedAs">Logged in as: </span>{{{Auth::user()->username}}}
                        </a>
                    </li>
                    <li {{ Request::is('profile') ? 'class="active"' : '' }}>
                        <a href="{{ URL::route("users/profile") }}">Profile Panel</a>
                    </li>
                    <li>
                        <a href="{{ URL::route("users/logout") }}">Logout</a>
                    </li>
                    <li {{ Request::is('viewMessages/*') || Request::is('viewMessage/*')? 'class="active"' : '' }}>
                        <a href="{{ URL::to("/viewMessages/".Auth::user()->id) }}">
                            @if (isset($newMessages))
                                <span class="badge pull-right">{{$newMessages}} new </span>
                            @endif 
                            
                            Messages
                        </a>
                    </li>
                    
                        @if (Auth::user()->userGroup===1 || Auth::user()->userGroup===2)
                            <li {{ Request::is('viewAllSeekers') ? 'class="active"' : '' }}>
                                <a href="{{ URL::route("seekers/viewAllSeekers") }}">Job Seekers</a>
                            </li>
                            <li {{ Request::is('myVacancies') ? 'class="active"' : '' }}>
                                <a href="{{ URL::route("vacancies/myVacancies") }}">
                                    @if (isset($newApplicants))
                                        <span class="badge pull-right">{{$newApplicants}} new applicants</span>
                                    @endif 

                                    My Vacancies
                                </a>
                            </li>
                            <li {{ Request::is('addVacancie') ? 'class="active"' : '' }}>
                                <a href="{{ URL::route("vacancies/add") }}">Add Vacancie</a>
                            </li>
                        @endif
                        
                        @if (Auth::user()->userGroup===1 || Auth::user()->userGroup===3)
                            <li {{ Request::is('myApplications') ? 'class="active"' : '' }}>    
                                <a href="{{ URL::route("applications/viewMy") }}">My Applications</a>
                            </li>
                            <li {{ Request::is('addJobSearch') ? 'class="active"' : '' }}>    
                                <a href="{{ URL::route("seekers/add") }}">Add JobSeeker data</a>
                            </li>
                        @endif
                @else
                    <li {{ Request::is('login') ? 'class="active"' : '' }}>
                        <a href="{{ URL::route("users/login") }}">Login</a>
                    </li>
                    <li {{ Request::is('register') ? 'class="active"' : '' }}>
                        <a href="{{ URL::route("users/register") }}">Register</a>
                    </li>
                    
                @endif
                           
                
                
                <li class="searchBar col-sm-5 navbar-right">
                {{ Form::open(array('url'=>'/search', 'class'=>'form-search', 'role'=>'form')) }}
            
                    <div class="input-group">
                        @if (Auth::check() && Auth::user()->userGroup!=3)
                            {{ Form::text('search', '', [
                                'class'=>'form-control',
                                'placeholder'=>'Search Users, Vacancies, Job Searchers...'
                            ])}}
                        @elseif (!Auth::check())
                            {{ Form::text('search', '', [
                                'class'=>'form-control',
                                'placeholder'=>'Search Vacancies...'
                            ])}}
                        @else
                            {{ Form::text('search', '', [
                                'class'=>'form-control',
                                'placeholder'=>'Search Users, Vacancies...'
                            ])}}
                        @endif
                        <span class="input-group-btn">
                        {{ Form::submit('Search', ['class'=>'btn btn-default'])}}
                        </span>
                    </div>
                {{ Form::close() }}
                </li>
                               
                
                </ul>  
            </nav>
        </div>
    </div>
@show