<!-- Epasts, kas tiek izsūtīts, kad nepieciešama paroles maiņa -->

<!DOCTYPE html>
<html lang="{{ Config::get('app.locale') }}">
    <head>
        <meta charset="utf-8" />
    </head>
    <body>
        <h1>{{ trans('emails.password-reset') }}</h1>
        
        <div>
            {{ trans('emails.to-reset-password') }}: 
            <a href="{{ URL::route("users/reset") . "?token=" . $token }}">{{ trans('emails.reset-my-password') }}</a>
        </div>
        <br>
        <div>
            {{ trans('emails.if-didnt-request') }}
        </div>
    </body>
</html>