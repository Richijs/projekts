@section("header")
    <div class="header">
        <div class="container">
            <h1>VakancesLV</h1>
            <nav class="navbar navbar-inverse" role="navigation">
                <ul class="nav navbar-nav">
                    <li {{ Request::is('/') ? 'class="active"' : '' }}>
                        <a href="{{ URL::route("home") }}">home</a
                    </li>
                    <li {{ Request::is('viewAllUsers') ? 'class="active"' : '' }}>
                        <a href="{{ URL::route("users/viewAllUsers") }}">ViewAllUsers</a>
                    </li>
                    <li {{ Request::is('viewAllVacancies') ? 'class="active"' : '' }}>
                        <a href="{{ URL::route("vacancies/viewAllVacancies") }}">ViewAllVacancies</a>
                    </li>
                    <li {{ Request::is('viewAllSeekers') ? 'class="active"' : '' }}>
                        <a href="{{ URL::route("seekers/viewAllSeekers") }}">ViewAllJobSeekers</a>
                    </li>
                    <li {{ Request::is('about') ? 'class="active"' : '' }}>
                        <a href="{{ URL::to("/about") }}">About</a>
                    </li>
                    <li {{ Request::is('contactAdmin') ? 'class="active"' : '' }}>
                        <a href="{{ URL::route("messaging/contact") }}">Contact Admin</a>
                    </li>
                        
                @if (Auth::check())
                    <li {{ Request::is('viewUser/'.Auth::user()->id) ? 'class="active"' : '' }}>
                        <a href="{{ URL::to("/viewUser/".Auth::user()->id) }}">
                            <span class="loggedAs">Logged in as: </span>{{{Auth::user()->username}}}
                        </a>
                    </li>
                    <li {{ Request::is('profile') ? 'class="active"' : '' }}>
                        <a href="{{ URL::route("users/profile") }}">My profile</a>
                    </li>
                    <li>
                        <a href="{{ URL::route("users/logout") }}">logout</a>
                    </li>
                    
                        @if (Auth::user()->userGroup===1 || Auth::user()->userGroup===2)
                            <li {{ Request::is('addVacancie') ? 'class="active"' : '' }}>
                                <a href="{{ URL::route("vacancies/add") }}">Add Vacancie</a>
                            </li>
                        @endif
                        
                        @if (Auth::user()->userGroup===1 || Auth::user()->userGroup===3)
                            <li {{ Request::is('addJobSearch') ? 'class="active"' : '' }}>    
                                <a href="{{ URL::route("seekers/add") }}">Add JobSeeker data</a>
                            </li>
                        @endif
                @else
                    <li {{ Request::is('login') ? 'class="active"' : '' }}>
                        <a href="{{ URL::route("users/login") }}">login</a>
                    </li>
                    <li {{ Request::is('register') ? 'class="active"' : '' }}>
                        <a href="{{ URL::route("users/register") }}">register</a>
                    </li>
                    
                @endif
                </ul>
                
                <div class="lang">       
                    <div class="btn-group btn-toggle">
                        <a href="{{ URL::to("/lang/lv") }}" class="btn btn-xs btn-default
                            @if (Config::get('app.locale')=='lv') btn-primary active @endif">
                            LV
                        </a>
                        <a href="{{ URL::to("/lang/en") }}" class="btn btn-xs btn-default
                            @if (Config::get('app.locale')=='en') btn-primary active @endif">
                            EN
                        </a>
                    </div>
                </div>
                
            </nav>
        </div>
    </div>
@show