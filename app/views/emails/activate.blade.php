<!-- Epasts, kas tiek izsūtīts, kad lietotājs tiek pabeidzis reģistrāciju/aktivizāciju -->

<!DOCTYPE html>
<html lang="{{ Config::get('app.locale') }}">
    <head>
        <meta charset="utf-8" />
    </head>
    <body>
        <h1>Registration at vakances was successfull, {{{$username}}}</h1>
        
        <br>
        <div>Thank You for using our site.</div>
        <div>   
            <a href="{{ URL::route("home") }}">{{ URL::route("home") }}</a>
        </div>
    </body>
</html>