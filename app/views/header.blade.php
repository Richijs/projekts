@section("header")
    <div class="header">
        <div class="container">
            <h1>VakancesLV</h1>
            <nav class="navbar navbar-inverse" role="navigation">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="{{ URL::route("home") }}">home</a
                    </li>
                    <li>
                <a href="{{ URL::route("users/viewAllUsers") }}">
                    ViewAllUsers
                </a>
                    </li>
                    <li>
                <a href="{{ URL::route("vacancies/viewAllVacancies") }}">
                    ViewAllVacancies
                </a>
                    </li>
                    <li>
                <a href="{{ URL::route("seekers/viewAllSeekers") }}">
                    ViewAllJobSeekers
                </a>
                </li>
                    <li>
                <a href="{{ URL::to("/about") }}">
                    About
                </a>
                </li>
                    <li>
                <a href="{{ URL::route("messaging/contact") }}">
                    Contact Admin
                </a>
                    </li>
            @if (Auth::check())
                <li>
                    <span class="loggedAs">Logged in as:</span>
                <a href="{{ URL::to("/viewUser/".Auth::user()->id) }}">
                    {{{Auth::user()->username}}}
                </a>
                </li>
                    <li>
                <a href="{{ URL::route("users/profile") }}">
                    My profile
                </a>
                </li>
                    <li>
                <a href="{{ URL::route("users/logout") }}">
                    logout
                </a>
                    </li>
                @if (Auth::user()->userGroup===1 || Auth::user()->userGroup===2)
                <li>
                    <a href="{{ URL::route("vacancies/add") }}">
                        Add Vacancie
                    </a>
                </li>
                @endif
                @if (Auth::user()->userGroup===1 || Auth::user()->userGroup===3)
                <li>    
                <a href="{{ URL::route("seekers/add") }}">
                        Add JobSeeker data
                    </a>
                </li>
                @endif
            @else
            <li>
                <a href="{{ URL::route("users/login") }}">
                    login
                </a>
                </li>
                    <li>
                <a href="{{ URL::route("users/register") }}">
                    register
                </a>
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