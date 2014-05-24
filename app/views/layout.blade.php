<!DOCTYPE html>
<html lang="{{ Config::get('app.locale') }}">
    <head>
        <meta charset="UTF-8" />
        <title>{{ trans('titles.site-title') }}</title>
        <meta name="viewport" content="width=device-width">
        <link rel="icon" href="favicon.ico" type="image/x-icon">
        {{ HTML::style('css/bootstrap.min.css'); }}
        {{ HTML::style('css/style.css'); }}
        {{ HTML::script('js/jquery-2.1.1.min.js'); }}
        {{ HTML::script('js/bootstrap.min.js'); }}
    </head>
    <body>
        @include("header")
        <div class="main">
            <div class="container">
                @if (Session::has('message-success'))
                    <div class="alert alert-success">
                        {{ Session::get('message-success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                            <span class="glyphicon glyphicon-remove"></span>
                        </button>
                    </div>
                @endif
                @if (Session::has('message-info'))
                    <div class="alert alert-info">
                        {{ Session::get('message-info') }}
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                            <span class="glyphicon glyphicon-remove"></span>
                        </button>
                    </div>
                @endif
                @if (Session::has('message-fail'))
                    <div class="alert alert-danger">
                        {{ Session::get('message-fail') }}
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                            <span class="glyphicon glyphicon-remove"></span>
                        </button>
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