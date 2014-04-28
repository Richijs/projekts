<!-- Epasts, kas tiek izsūtīts, kad nepieciešama paroles maiņa -->

<!DOCTYPE html>
<html lang="{{ Config::get('app.locale') }}">
    <head>
        <meta charset="utf-8" />
    </head>
    <body>
        <h1>Password Reset</h1>
        To reset your password, complete this form:
        <div>   
            <a href="{{ URL::route("users/reset") . "?token=" . $token }}">HERE..... (Click on me)</a>
        </div>
        <div>
            If you didnt request this action, ignore and delete this e-mail
        </div>
    </body>
</html>