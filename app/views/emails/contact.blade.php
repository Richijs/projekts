<!-- Epasts, kas tiek izsūtīts, kad lietotājs sazinās ar administratoru -->

<!DOCTYPE html>
<html lang="{{ Config::get('app.locale') }}">
    <head>
        <meta charset="utf-8" />
    </head>
    <body>
        <h1>New vakances Message from user: {{{$username}}}</h1>
        
        <div style="white-space:pre-line;">   
            {{{$messageText}}}
        </div>
        
        <br>
        <h2>Reply:</h2>
        <div>
            <a href="mailto:{{{$email}}}">{{{$email}}}</a>
        </div>
    </body>
</html>