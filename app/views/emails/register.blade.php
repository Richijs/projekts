<!-- Epasts, kas tiek izsūtīts, kad lietotājs tiek reģistrēts -->

<!DOCTYPE html>
<html lang="lv">
    <head>
        <meta charset="utf-8" />
    </head>
    <body>
        <h1>Registration successfull, {{{$username}}}</h1>
        
        COngratz! YOu registered here!
        <div>   
            <a href="{{ URL::route("home") }}">{{ URL::route("home") }}</a>
        </div>
    </body>
</html>