<?php
include "setup.php";

use WIFI\Fdb\Mysql;
use WIFI\Fdb\Validieren;

    if(!empty($_POST)){
        // validieren
        $valid = new Validieren();
        $valid->istAusgefuellt($_POST["benutzername"],"Benutzername");
        $valid->istAusgefuellt($_POST["passwort"], "Passwort");

        if(!$valid->fehlerAufgetreten()){
            // wenn kein Fehler aufgetreten ist, weitermachen mit einloggen
            $db= Mysql::getInstanz();
            // $db->verbinden();
            $sqlBenutzername = $db->escape($_POST["benutzername"]);
            
            $result = $db->query("SELECT * from benutzer where benutzername ='{$sqlBenutzername}';");
            $benutzer = $result->fetch_assoc();
           
            if(empty($benutzer)|| !password_verify ( $_POST["passwort"] , $benutzer["passwort"] )){
                // fehler benutzer existiert nicht
                $valid->fehlerHinzu("Benutzername und/oder Passwort ist falsch!");
            } else {
                // Alles OK -> Login in $_session merken
                $_SESSION["eingeloggt"]=true;
                $_SESSION["benutzername"]=$benutzer["benutzername"];
                $_SESSION["benutzer_id"]=$benutzer["id"];
                
                header("location: index.php");
                exit();
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loginbereich zur Fahrzeug-DB</title>
</head>
<body>
    <h1>Loginbereich zur Fahrzeug-DB</h1>


<?php
    if(!empty($valid)){
        echo  $valid->fehlerListeHtml() ;
    }
?>


<form method="post">
        <div>
            <label for="benutzername"> Benutzername: </label>
            <input type="text" name="benutzername" id="benutzername" >
        </div>
        <div>
            <label for="passwort"> Passwort: </label>
            <input type="password" name="passwort" id="passwort" >
        </div>
        <div>
            <button type="submit">Einloggen</button>
            
        </div>
    </form>
</body>
</html>