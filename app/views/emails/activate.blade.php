<!-- Epasts, kas tiek izsūtīts, kad lietotājs tiek pabeidzis reģistrāciju/aktivizāciju -->

<!DOCTYPE html>
<html lang="{{ Config::get('app.locale') }}">
    <head>
        <meta charset="utf-8" />
    </head>
    <body>
        <h1>Registration at vakances.lv successfull, {{{$username}}}</h1>
        
        Thank You for using our site.
        
        <div>   
            <a href="{{ URL::route("home") }}">{{ URL::route("home") }}</a>
        </div>
    </body>
</html>