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
                <a href="{{ URL::route("users/logout") }}">
                    logout
                </a>
                |
                <a href="{{ URL::route("users/profile") }}">
                    profile
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
        </div>
    </div>
@show