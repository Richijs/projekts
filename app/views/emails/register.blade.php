<!-- Epasts, kas tiek izsūtīts, kad lietotājs reģistrējies (tiek piedāvāta aktivizācija) -->

<!DOCTYPE html>
<html lang="{{ Config::get('app.locale') }}">
    <head>
        <meta charset="utf-8" />
    </head>
    <body>
        <h1>Activate your account, {{{ $username }}}</h1>
        To activate your account, complete this action:
        <div>   
            <a href="{{ URL::to("/activate") . "?code=" . $code."&id=".$id }}">HERE..... (Click on me)</a>
        </div>
        <div>
            If you didnt request this action, ignore and delete this e-mail
        </div>
    </body>
</html>