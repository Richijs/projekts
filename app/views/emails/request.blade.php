<!-- Epasts, kas tiek izsūtīts, kad nepieciešama paroles maiņa -->

<!DOCTYPE html>
<html lang="{{ Config::get('app.locale') }}">
    <head>
        <meta charset="utf-8" />
    </head>
    <body>
        <h1>Password Reset</h1>
        To reset your vakances.lv password, complete the following form:
        <div>   
            <a href="{{ URL::route("users/reset") . "?token=" . $token }}">Reset My Password</a>
        </div>
        <div>
            If you didnt request this action, ignore and delete this e-mail
        </div>
    </body>
</html>