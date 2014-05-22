<!-- Epasts, kas tiek izsūtīts, kad nepieciešama paroles maiņa -->

<!DOCTYPE html>
<html lang="{{ Config::get('app.locale') }}">
    <head>
        <meta charset="utf-8" />
    </head>
    <body>
        <h1>Password Reset</h1>
        
        <div>
            To reset your vakances password, complete the following form: 
            <a href="{{ URL::route("users/reset") . "?token=" . $token }}">Reset My Password</a>
        </div>
        <br>
        <div>
            If you did'nt request this action, ignore and delete this e-mail
        </div>
    </body>
</html>