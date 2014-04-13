@section("header")
    <div class="header">
        <div class="container">
            <h1>Vakances   l l l l v</h1>
            <nav>
                <a href="{{ URL::route("home") }}">
                    home
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