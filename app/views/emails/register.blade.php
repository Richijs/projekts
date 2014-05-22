<!-- Epasts, kas tiek izsūtīts, kad lietotājs reģistrējies (tiek piedāvāta aktivizācija) -->

<!DOCTYPE html>
<html lang="{{ Config::get('app.locale') }}">
    <head>
        <meta charset="utf-8" />
    </head>
    <body>
        <h1>Activate your account, {{{ $username }}}</h1>
        
        <div>
            To activate your vakances account - Visit the following link: 
            <a href="{{ URL::to("/activate") . "?code=" . $code."&id=".$id }}">Account Activation</a>
        </div>
        <br>
        <div>
            If you did'nt request this action, ignore and delete this e-mail.
        </div>
    </body>
</html>