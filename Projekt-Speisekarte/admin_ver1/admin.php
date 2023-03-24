<?php
include "inhalt/funktionen.php";
$db="speisekarte";
$fehlermeldung="";
// if( isset($login_ok)){
//     $login_ok=0;
//     echo "bin drin <br>";
// }
session_start();
if(empty($_SESSION)){
    $_SESSION["login"]=0;
}

echo'S_Session:';
echo"<pre>"; //print_r Inhalt aus einem Array darstellen (nur zum debuggen)
print_r($_SESSION);
echo "</pre>";
echo'S_Post:';
echo"<pre>"; //print_r Inhalt aus einem Array darstellen (nur zum debuggen)
print_r($_POST);
echo "</pre>";



// datenbankanbindung
// $con= @new mysqli("","root","","speisekarte"); //Das @ bedeutet silent und unterdrückt die ausgabe von Fehlermeldungen (notwendig gegen Hackerangriffe die sonst eine Info zur DB bekommen würden)
// if($con->connect_error){
//     exit("Fehler beim Verbindungsaufbau");
// }
// $sql="select * from benutzer";
// if($result=$con->query($sql)){
//     if($result->num_rows == 0){
//         echo "Keine Ergebnisse! <br>";
//     } else{
//         while($daten_satz=$result->fetch_assoc())
//             echo    $daten_satz["benutzer"]. ", " . 
//                     $daten_satz["nachname"]. ", " .
//                     $daten_satz["vorname"]. ", " .
//                     $daten_satz["email"]. ", <br>";
//         $result->close();
//     }
// };


if($_SESSION["login"]==0){
    if(!empty($_POST) && isset($_POST["ben"])){
        // Datenbankverbindung herstellen und benutzer abfragen
        $con= db_con($db);
        $sql="SELECT passwort FROM benutzer WHERE benutzer='". $_POST["ben"]."'";
        if($result=$con->query($sql)){ 
            if($result->num_rows == 0){//abfragen ob der Benutzer existiert
                $fehlermeldung="Benutzer nicht vorhanden!";
                $include_datei="login";
            } else{
                $daten_satz=$result->fetch_assoc(); //den 1. Datensatz vom Ergebnis ($result) in $daten_satz übertragen
                    if( password_verify($_POST["p_wort"] , $daten_satz["passwort"])){ 
                        $_SESSION["login"]=1;
                        $fehlermeldung="Sie haben sich erfolgreich angemeldet";
                        $include_datei="verwaltung";
                
                    } else {
                        $fehlermeldung="Benutzername und/oder Passwort sind falsch!";
                        $include_datei="login";
                    }
                $result->close();
            }
        } else {
            $include_datei="login";
        }
        $con->close();
    } else {
        echo '$_post leer';
        $_SESSION["login"]=0;
        $include_datei="login";
    }
} else{
    if(!empty($_POST["seite"])){
        $_SESSION["seite"]=$_POST["seite"];
        if ($_SESSION["seite"][0]=="a"){ //allergene
            // $_SESSION["seite"]="allergene";
            $include_datei="allergene";
        } else if ($_SESSION["seite"][0]=="s"){ //speisen
            // $_SESSION["seite"]="speisen";
            $include_datei="speisen";
        } else if ($_SESSION["seite"][0]=="g"){ //getränke
            // $_SESSION["seite"]="speisen";
            $include_datei="getraenke";
        } else if ($_SESSION["seite"][0]=="z"){ //getränke
            // $_SESSION["seite"]="speisen";
            $include_datei="zutaten";
        } else if ($_SESSION["seite"]=="login"){ //login
            // $_SESSION["seite"]="speisen";
            $include_datei="login";
            $_SESSION["login"]=0;
        } else { //err 404
            $include_datei="err404";
        }
    } else{ //irgendeinfehler gehe auf die login seite zurück.
        $_SESSION["login"]=0;
        $include_datei="login";
    }
    
}

// echo "Session char seite stelle1: ". $_SESSION["seite"][0] ."<br>";
// echo "include datei: " . $include_datei."<br>";

// password_verify($passwort, $hash)
//überprüfung sollte noch von der DB kommen!!!
    
    // echo "Login überprüfen.". $con->connect_error ."_ <br>";

// echo $_SESSION["login"]."<br>";
// echo password_hash("1",PASSWORD_DEFAULT)."<br>";

// echo"<pre>"; //print_r Inhalt aus einem Array darstellen (nur zum debuggen)
// print_r($con);
// echo "</pre>";





// {
/** zum Verschlüsseln des Passwortes verwendeter teil!
 * Dieser Code führt einen Benchmark Ihres Servers durch, um festzustellen,
 * wie hoch die Kosten sind, die Sie sich leisten können. Sie sollten die
 * höchsten Kosten einstellen, die Sie sich leisten können, ohne dass der
 * Server zu sehr verlangsamt wird. 8-10 ist ein guter Grundwert, und mehr ist
 * gut, wenn Ihre Server schnell genug sind. Der folgende Code zielt auf eine
 * Dehnungszeit von ≤ 50 Millisekunden ab, was ein guter Richtwert für Systeme
 * ist, die interaktive Anmeldungen verarbeiten.
 */
// $zeitZiel = 0.05; // 50 Millisekunden

// $kosten = 8;
// do {
//     $kosten++;
//     $start = microtime(true);
//     password_hash("test", PASSWORD_BCRYPT, ["cost" => $kosten]);
//     $ende = microtime(true);
// } while (($ende - $start) < $zeitZiel);

// echo "Ermittelte angemessene Kosten: " . $kosten;
// }



include("inhalt/kopf.php");
include("inhalt/$include_datei.php");
include("inhalt/fuss.php");

echo'S_Session:';
echo"<pre>"; //print_r Inhalt aus einem Array darstellen (nur zum debuggen)
print_r($_SESSION);
echo "</pre>";
echo'S_Post:';
echo"<pre>"; //print_r Inhalt aus einem Array darstellen (nur zum debuggen)
print_r($_POST);
echo "</pre>";
?>

