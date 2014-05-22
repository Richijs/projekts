<!-- Epasts, kas tiek izsūtīts, kad lietotājs tiek pabeidzis reģistrāciju/aktivizāciju -->

<!DOCTYPE html>
<html lang="{{ Config::get('app.locale') }}">
    <head>
        <meta charset="utf-8" />
    </head>
    <body>
        <h1>{{ trans('emails.registration-at-vacances-was-successfull') }}, {{{$username}}}</h1>
        
        <br>
        <div>{{ trans('emails.thanks-for-using-site') }}</div>
        <div>   
            <a href="{{ URL::route("home") }}">{{ URL::route("home") }}</a>
        </div>
    </body>
</html>