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