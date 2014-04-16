<!DOCTYPE html>
<html lang="{{ Config::get('app.locale') }}">
    <head>
        <meta charset="UTF-8" />
        <title>Vakances.lv</title>
        <meta name="viewport" content="width=device-width">
        <link rel="icon" href="favicon.ico" type="image/x-icon">
        {{ HTML::style('css/style.css'); }}
        {{ HTML::style('css/bootstrap.css'); }} <!-- TODO: rest to be added -->
    </head>
    <body>
        @include("header")
        <div class="main">
            <div class="container">
                @if (Session::has('message-success'))
                    <div class="alert alert-success">
                        {{ Session::get('message-success') }}
                    </div>
                @endif
                @if (Session::has('message-info'))
                    <div class="alert alert-info">
                        {{ Session::get('message-info') }}
                    </div>
                @endif
                @if (Session::has('message-fail'))
                    <div class="alert alert-fail">
                        {{ Session::get('message-fail') }}
                    </div>
                @endif
                
                <div class="content">
                    @yield("content")
                </div>
            </div>
        </div>
        @include("footer")
    </body>
</html>