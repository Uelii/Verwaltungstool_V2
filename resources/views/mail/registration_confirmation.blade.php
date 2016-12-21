<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Your account has been successfully created!</h2>

<div>
    <p>Hi {{ $name }},</p>

    <p>Below you find the details of your account.</p>
    <hr>

    <b>Name: </b> {{ $name }} </br>
    <b>E-Mail: </b> {{ $email }} </br>
    <b>Password: </b> {{ $password }} </br>

    <p>Best regards, </br>
    Fabian Kipfer, Michel Konrad, Rene Meilbeck
    </p>

    <hr>
    <img height="50px" src="C:/xampp/htdocs/immogate/public/img/immoGate_v1.png">
</div>

</body>
</html>