<?php
// weiterleiten nach 5 sekunden auf die Login-Seite
header("refresh:5; ../index.html"); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin.css">
    <title>Logout</title>
</head>
<body>
    <h1>Logout aus dem Speisekarten-Administrationsbereich.</h1>
    <p>Sie wurden erfolgreich ausgeloggt und werden automatisch auf die Speisekarte weitergeleitet</p>
    <p>
        <a href="login.php">Weiter zum login</a>
    </p>
</body>
</html>