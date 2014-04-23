@section("header")
    <div class="header">
        <div class="container">
            <h1>VakancesLV</h1>
            <nav>
                <a href="{{ URL::route("home") }}">
                    home
                </a>
                |
                <a href="{{ URL::route("users/viewAllUsers") }}">
                    ViewAllUsers
                </a>
                |
                <a href="{{ URL::route("vacancies/viewAllVacancies") }}">
                    ViewAllVacancies
                </a>
                |
                <a href="{{ URL::to("/about") }}">
                    About
                </a>
                |
            @if (Auth::check())
                Logged in as:
                <a href="{{ URL::to("/viewUser/".Auth::user()->id) }}">
                    {{{Auth::user()->username}}}
                </a>
                |
                <a href="{{ URL::route("users/logout") }}">
                    logout
                </a>
                |
                <a href="{{ URL::route("users/profile") }}">
                    My profile
                </a>
                |
                @if (Auth::user()->userGroup===1 || Auth::user()->userGroup===2)
                    <a href="{{ URL::route("vacancies/add") }}">
                        Add Vacancie
                    </a>
                    |
                @endif
                @if (Auth::user()->userGroup===1 || Auth::user()->userGroup===3)
                    <a href="{{ URL::route("seekers/add") }}">
                        Add JobSeeker data
                    </a>
                    |
                @endif
            @else
                <a href="{{ URL::route("users/login") }}">
                    login
                </a>
                |
                <a href="{{ URL::route("users/register") }}">
                    register
                </a>
            @endif
            </nav>
            <div class="lang">       
                <div class="btn-group btn-toggle">
                    <a href="{{ URL::to("/lang/lv") }}">
                        <button class="btn btn-xs btn-default
                        @if (Config::get('app.locale')=='lv') btn-primary active @endif">LV</button>
                    </a>
                    <a href="{{ URL::to("/lang/en") }}">
                        <button class="btn btn-xs btn-default
                        @if (Config::get('app.locale')=='en') btn-primary active @endif">EN</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
@show