<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/admin.css">
    <title>Anmeldung zur Speisekartenverwaltung</title>

</head>
<body>
<?php

include "config.php";
include "classes/Validieren.php";
include "classes/Mysql.php";

use WIFI\SK\Validieren;
use WIFI\SK\Mysql;

    session_start();
    
    if(!empty($_POST)){
        $valid= new Validieren();
        $valid->istAusgefuellt($_POST["ben"],"Benutzer");
        $valid->istAusgefuellt($_POST["pwort"],"Passwort");
        
        if( !$valid->fehlerAufgetreten()){
            
            // Datenbankverbindung herstellen und benutzer abfragen
            $con = Mysql::getInstanz();
            // $con= @new mysqli("","root","","speisekarte"); //Das @ bedeutet silent und unterdrückt die ausgabe von Fehlermeldungen (notwendig gegen Hackerangriffe die sonst eine Info zur DB bekommen würden)
 
            if($con->verbindungsfehler()){
                exit("Fehler beim Verbindungsaufbau");
            };

            $sql_ben= $con->escape( $_POST["ben"] );
            $sql_pwort= $con->escape( $_POST["pwort"] );

            $sql="SELECT passwort FROM benutzer WHERE `benutzer`='". $sql_ben."'";
            if($result=$con->query($sql)){ 
                if($result->num_rows == 0){//abfragen ob der Benutzer existiert
                    $valid->fehlerDazu("Benutzernamen und/oder Passwort nicht korrekt!");
                    
                } else {
                    $daten_satz=$result->fetch_assoc(); //den 1. Datensatz vom Ergebnis ($result) in $daten_satz übertragen
                        if( password_verify($sql_pwort , $daten_satz["passwort"])){ 
                            $_SESSION["login"]=$sql_ben;
                             echo "Sie haben sich erfolgreich angemeldet";
                            header("location: index.php");
                            exit();
                    
                        } else {
                            $valid->fehlerDazu("Benutzernamen und/oder Passwort nicht korrekt!");;
                            $include_datei="login";
                        }
                    $result->close();
                }
            } else {
                $fehlermeldung="Es ist ein Fehler aufgetreten!";
            }
            // $con->close();
        }
    }
?>
    <h1>Anmelung zur Speisekartenverwaltung</h1>
    <p class="center">Bitte geben sie ihre Benutzerdaten ein:
    <?php
        echo '<p class="center">';
         
            if( !empty($valid) ){
                echo $valid->fehlerAusgabeHtml() ;
            }
        ?>
    </p>
    
    <form action="#" method="post">
    <div>
            <label for="ben">Benutzer: </label>
            <input type="text" name="ben" id="ben" value="<?php if(isset($_POST["ben"])){echo $_POST["ben"];} ?>">
        </div>
        <div>
            <label for="pwort">Passwort: </label>
            <input type="password" name="pwort" id="pwort">
        </div>
        <button type="submit">Anmelden</button>
    </form>
</body>
</html>