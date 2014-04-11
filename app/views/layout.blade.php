<!DOCTYPE html>
<html lang="lv">
    <head>
        <meta charset="UTF-8" />
        <title>Vakances.lv</title>
        <meta name="viewport" content="width=device-width">
        <link rel="icon" href="favicon.ico" type="image/x-icon">
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
        @include("header")
        <div class="content">
            <div class="container">
                @if (Session::has('message'))
                <!-- noklusçjuma klase ir alert-info -->
                <div class="alert {{ Session::get('alert-class', 'alert-info') }}">
                     {{ Session::get('message') }}
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