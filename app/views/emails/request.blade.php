<!-- Epasts, kas tiek izs�t�ts, kad nepiecie�ama paroles mai�a -->

<!DOCTYPE html>
<html lang="lv">
    <head>
        <meta charset="utf-8" />
    </head>
    <body>
        <h1>Password Reset</h1>
        To reset your password, complete this form:
        <div>   
            <a href="{{ URL::route("users/reset") . "?token=" . $token }}">HERE..... (Click on me)</a>
        </div>
    </body>
</html>