<?php
include "funktionen.php";

    if(!empty($_POST)){
        //Validieren des Benutzers
        if( empty($_POST["benutzername"]) || empty($_POST["passwort"])){
            $error = "Benutzername oder Passwort waren leer!";
        } else {
            //Benutzer und Passwort wurden übergeben
            // => in der DB nachsehen ob der Benutzer existiert.
            
            // Damit die eingegebenen daten die von $post und $get kommen keinen Unsinn
            // in der db anrichten können immer den befehl "mysqli_real_escape_string"
            // drüberlaufen lassen, damit gefährliche Zeichen maskiert werden z.b.: wird aus " => /"
            $sql_benutzername=escape($_POST["benutzername"]);
            
            // echo "SELECT * from benutzer where benutzername=\"{$_POST["benutzername"]}\";";
            
            // echo($sql_benutzername);echo "<br>";
            // echo($_POST["benutzername"]);

            // Datenbank fragen ob der Benutzer existiert
            $result = query ("SELECT * from benutzer where benutzername='{$sql_benutzername}';");

            // auswerten des Abfrageergebnisses:
            // einen (ersten) Datensatz 
            $row = fetch ($result); 
            // liefert die erste Zeile der Abfrage retour oder Null wenn es kein Ergebnis der Abfrage gibt
            if($row){
                // Benutzer Existiert => PWD überprüfen (unverschlüsselte version if($_POST["passwort"]==$row["passwort"]))
                if( password_verify ( $_POST["passwort"] , $row["passwort"] ) ){
                    // Login war erfolgreich, sezten der Variable $_Session["eingeloggt"] damit er auf den weiteren seiten nicht rausfliegt.
                    $_SESSION["eingeloggt"]=true;
                    $_SESSION["benutzername"]=$row["benutzername"];

                    //letztes Login & Anzahl in DB speichern.
                    query("UPDATE `benutzer` SET `letztes_login`=now(),`anzahl_logins`=anzahl_logins+1 WHERE benutzername='{$row["benutzername"]}'");


                    // umleitung auf die Index.php seite
                    header("location: index.php");
                    exit();

                } else { 
                    // PWD war falsch, fehlermeldung setzen
                    // am besten eine Fehlermeldung auf Benutzer und Passwort verwenden, dann kann man keine Rückschlüsse auf Benutzer/Passwort ziehen
                    $error="Benutzername oder Passwort waren falsch!";
                }
                // var_dump($row);
            } else{ 
                // Benutzer existiert nicht
                $error="Benutzername oder Passwort waren falsch!";
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
    <title>Loginbereich zur Rezepteverwaltung</title>
</head>
<body>
    <h1>Loginbereich zur Rezepteverwaltung</h1>
<?php
    if( !empty($error) ){
        echo "<p style='color:red'> $error </p>";
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