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
                <a href="{{ URL::route("users/viewAllUsers") }}">{{ trans('titles.site-users') }}</a>
            </li>
            <li {{ Request::is('viewUser/'.Auth::user()->id) ? 'class="active"' : '' }}>
                <a href="{{ URL::to("/viewUser/".Auth::user()->id) }}">
                    <span class="loggedAs">{{ trans('titles.logged-in-as') }}: </span>{{{Auth::user()->username}}}
                </a>
            </li>
            <li {{ Request::is('profile') ? 'class="active"' : '' }}>
                <a href="{{ URL::route("users/profile") }}">{{ trans('titles.profile-panel') }}</a>
            </li>
            <li>
                <a href="{{ URL::route("users/logout") }}">{{ trans('titles.logout') }}</a>
            </li>
            <li {{ Request::is('viewMessages/*') || Request::is('viewMessage/*')? 'class="active"' : '' }}>
                <a href="{{ URL::to("/viewMessages/".Auth::user()->id) }}">
                    @if (isset($newMessages))
                        <span class="badge pull-right">{{$newMessages}} {{ trans('content.new-as') }}! </span>
                    @endif 
                            
                    {{ trans('titles.messages-cap') }}
                </a>
            </li>
                    
            @if (Auth::user()->userGroup===1 || Auth::user()->userGroup===2)
            <li {{ Request::is('viewAllSeekers') ? 'class="active"' : '' }}>
                <a href="{{ URL::route("seekers/viewAllSeekers") }}">{{ trans('titles.job-seekers') }}</a>
            </li>
            <li {{ Request::is('myVacancies') ? 'class="active"' : '' }}>
                <a href="{{ URL::route("vacancies/myVacancies") }}">
                @if (isset($newApplicants))
                    <span class="badge pull-right">{{$newApplicants}} {{ trans('content.new-applicants') }}</span>
                @endif 

                {{ trans('buttons.my-vacancies') }}
                </a>
            </li>
            <li {{ Request::is('addVacancie') ? 'class="active"' : '' }}>
                <a href="{{ URL::route("vacancies/add") }}">{{ trans('titles.add-vacancie') }}</a>
            </li>
            @endif
                        
            @if (Auth::user()->userGroup===1 || Auth::user()->userGroup===3)
            <li {{ Request::is('myApplications') ? 'class="active"' : '' }}>    
                <a href="{{ URL::route("applications/viewMy") }}">{{ trans('buttons.my-applications') }}</a>
            </li>
            <li {{ Request::is('addJobSearch') ? 'class="active"' : '' }}>    
                <a href="{{ URL::route("seekers/add") }}">{{ trans('titles.add-jobseek-data') }}</a>
            </li>
            @endif
        @else
            <li {{ Request::is('login') ? 'class="active"' : '' }}>
                <a href="{{ URL::route("users/login") }}">{{ trans('titles.log-in') }}</a>
            </li>
            <li {{ Request::is('register') ? 'class="active"' : '' }}>
                <a href="{{ URL::route("users/register") }}">{{ trans('titles.register') }}</a>
            </li>
        @endif
                           
            <li class="searchBar col-sm-5 navbar-right">
                {{ Form::open(array('url'=>'/search', 'class'=>'form-search', 'role'=>'form')) }}
            
                <div class="input-group">
                    @if (Auth::check() && Auth::user()->userGroup!=3)
                        {{ Form::text('search', '', [
                            'class'=>'form-control',
                            'placeholder'=> trans('forms.search-users-vacancies-seekers')
                        ])}}
                    @elseif (!Auth::check())
                        {{ Form::text('search', '', [
                            'class'=>'form-control',
                            'placeholder'=> trans('forms.search-vacancies')
                        ])}}
                    @else
                        {{ Form::text('search', '', [
                            'class'=>'form-control',
                            'placeholder'=> trans('forms.search-users-vacancies')
                        ])}}
                    @endif
                    
                    <span class="input-group-btn">
                        {{ Form::submit(trans('forms.search'), ['class'=>'btn btn-default'])}}
                    </span>
                </div>
                {{ Form::close() }}
            </li>
                               
        </ul>  
    </nav>
        
    </div>
</div>
@show