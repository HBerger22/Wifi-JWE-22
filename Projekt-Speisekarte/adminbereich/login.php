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

    session_start();
//     echo'S_Session:';
// echo"<pre>"; //print_r Inhalt aus einem Array darstellen (nur zum debuggen)
// print_r($_SESSION);
// echo "</pre>";
// echo'S_post:';
// echo"<pre>"; //print_r Inhalt aus einem Array darstellen (nur zum debuggen)
// print_r($_POST);
// echo "</pre>";
    if(!empty($_POST)){
        if( empty($_POST["ben"]) || empty($_POST["pwort"])){
            $fehlermeldung = "Benutzername oder Passwort waren leer!";
        } else {
            
            // Datenbankverbindung herstellen und benutzer abfragen
            $con= @new mysqli("","root","","speisekarte"); //Das @ bedeutet silent und unterdrückt die ausgabe von Fehlermeldungen (notwendig gegen Hackerangriffe die sonst eine Info zur DB bekommen würden)
            // $con= @new mysqli("localhost","jwe_bh","6td4t~O1jZ75f5@e","obinet_jwe_bh_db1"); //Das @ bedeutet silent und unterdrückt die ausgabe von Fehlermeldungen (notwendig gegen Hackerangriffe die sonst eine Info zur DB bekommen würden)

            if($con->connect_error){
                exit("Fehler beim Verbindungsaufbau");
            };

            $sql_ben= mysqli_real_escape_string($con, $_POST["ben"]);
            $sql_pwort= mysqli_real_escape_string($con, $_POST["pwort"]);

            $sql="SELECT passwort FROM benutzer WHERE `benutzer`='". $sql_ben."'";
            if($result=$con->query($sql)){ 
                if($result->num_rows == 0){//abfragen ob der Benutzer existiert
                    $fehlermeldung="Benutzernamen oder Passwort nicht korrekt!";
                    
                } else {
                    $daten_satz=$result->fetch_assoc(); //den 1. Datensatz vom Ergebnis ($result) in $daten_satz übertragen
                        if( password_verify($sql_pwort , $daten_satz["passwort"])){ 
                            $_SESSION["login"]=$sql_ben;
                             echo "Sie haben sich erfolgreich angemeldet";
                            header("location: index.php");
                            exit();
                    
                        } else {
                            $fehlermeldung="Benutzername und/oder Passwort sind falsch!";
                            $include_datei="login";
                        }
                    $result->close();
                }
            } else {
                $fehlermeldung="Es ist ein Fehler aufgetreten!";
            }
            $con->close();
        }
    }
?>
    <h1>Anmelung zur Speisekartenverwaltung</h1>
    <p>Bitte geben sie ihre Benutzerdaten ein:</p>
    <p>
        <?php 
            if(isset($fehlermeldung)){
                echo "<p style='color:red'>".$fehlermeldung."</p>";

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