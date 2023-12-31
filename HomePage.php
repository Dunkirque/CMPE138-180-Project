<!DOCTYPE html>
<!--
    //SJSU CMPE 138 Fall 2023 Team 11
-->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DMV-Like</title>
</head>
<body>

    <h1>DMV-Like</h1>
    <h2>
    <a href="LoginPage.php">
        <button type="button">I am a Database User with an Account (Login)</button>
    </a>
    </h2>

    <h2>
    <a href="RegistrationPage.php">
        <button type="button">I am a Database User without an Account (Registration)</button>
    </a>
    </h2>

    <h2>
    <a href="LoginAdminPage.php">
        <button type="button">I am a Database Admin</button>
    </a>
    </h2>

    <h2>
    <form method="post" action="init_admin.php">
    <input type="hidden" name="init_admin" value="true">
    <button type="submit">Initialize Admin Account</button>
</form>
    </h2>

</body>
</html>
