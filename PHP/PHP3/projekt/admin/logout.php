<?php
session_start();

// setzt nur die jeweiligen Eintrag zurück.
unset($_SESSION["eingeloggt"]);

// Alle $_Session Variablen löschen
session_unset();

// vernichtet die ganze Session inkl. dazugehörigen cookie
session_destroy();

// weiterleiten nach 5 sekunden auf die Login-Seite
header("refresh:5; login.php"); 

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fahrzeug-DB</title>
</head>
<body>
    <h1>Logout aus dem Fahrzeug-DB.</h1>
    <p>Sie wurden erfolgreich ausgeloggt.</p>
    <p>
        <a href="login.php">Weiter zum login</a>
    </p>
</body>
</html>