<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--  PHP Code kann überall stehen-->
    <title> <?php echo"PHP - Grundlagen 01"; ?> </title>
</head>
<body>
    <h1>Echo mit PHP</h1>
    <?php
        echo "Hallo Welt!"; //es erfolg kein Zeilenumbruch daher wird die nächste Zeile in einer Wurst ausgegeben.
        echo "Hallo "; echo "Welt!";
        echo '<br>';
        // Hier ist es schöner, da der HTML Tag im Echo befehl für einen Umbruch sorgt.
        echo "Hallo Welt! <br>";
        echo "Hallo "; echo "Welt! <br>";

       
       


    ?>
</body>
</html>