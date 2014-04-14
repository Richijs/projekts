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
                <a 
                    @if (Config::get('app.locale')=='lv')
                    class="active"
                    @endif
                    href="{{ URL::to("/lang/lv") }}">LV</a>
                &nbsp;
                <a 
                    @if (Config::get('app.locale')=='en')
                    class="active"
                    @endif
                    href="{{ URL::to("/lang/en") }}">EN</a>
            </div>
        </div>
    </div>
@show