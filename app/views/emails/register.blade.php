<!-- Epasts, kas tiek izsūtīts, kad lietotājs reģistrējies (tiek piedāvāta aktivizācija) -->

<!DOCTYPE html>
<html lang="{{ Config::get('app.locale') }}">
    <head>
        <meta charset="utf-8" />
    </head>
    <body>
        <h1>{{ trans('emails.activate-account') }}, {{{ $username }}}</h1>
        
        <div>
            {{ trans('emails.to-activate-account') }}: 
            <a href="{{ URL::to("/activate") . "?code=" . $code."&id=".$id }}">{{ trans('emails.account-activation') }}</a>
        </div>
        <br>
        <div>
            {{ trans('emails.if-didnt-request') }}
        </div>
    </body>
</html>