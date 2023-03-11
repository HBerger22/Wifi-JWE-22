<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP - Grundlagen 10 - Regular Expression</title>
</head>
<body>
    <h1>Regular Expression - Komplexe Suchmuster</h1>

    <?php
        $name= "hal1Q@lo";
        $datum= "24.02.2025";
        // Benutzername auf gültige Zeichen überprüfen.
        echo "<em><strong>Benutzernamen auf gültige Zeichen überprüfen.</strong></em>"; 
        echo "<br>";
        echo "Name: ".$name;
        echo "<br>";
        
        // if(preg_match("/^[0-9]+$/",$name)){
        //     echo "Gültig. <br>";
        // } else {
        //     echo "Der benutzer namen enthält ungültige Zeichen!";
        // }

        if(preg_match("/(?=.*[a-zA-Z]+.*){1,}(?=.*\d+.*){1,}(?=.*[@$!%*#?&]+.*){1,}/",$name)){
            echo "Gültig. <br>";
        } else {
            echo "Der benutzer namen enthält ungültige Zeichen!";
        }



    ?>
    
</body>
</html>