<?php
session_start();

//Verbindung zur DB herstellen.
$db = mysqli_connect("localhost","root","","php2_2023");

// definieren des Zeichensatzes zur kommunikation mit der DB
mysqli_set_charset($db,"utf8");

// Diese Funktion überprüft ob der User eingeloggt ist, falls nicht wird er auf die Seite Logon.php umgeleitet.
function ist_eingeloggt(){
    if( empty($_SESSION["eingeloggt"]) ){
        // kein benutzer eingeloggt --> umleiten zum login
        header("location: login.php");
        exit; //mit header wird auf eine andere Seite umgeleitet und mit Exit wird das aktuelle script beendet
    }
}



// allgemeine Funktionen zur kürzeren Schreibweise für den DB zugriff.
// kurzform für: mysqli_real_escape_string($db, $wort)
function escape ($wort){
    global $db;
    return mysqli_real_escape_string($db, $wort);
}

// Kurzform für: mysqli_query($db,$statement);
function query ($statement){
    global $db;
    $result = mysqli_query($db,$statement) or die(mysqli_error($db)."<br>".$statement);
    return $result;
}

// kurzform für: mysqli_fetch_assoc($result);
function fetch ($result){
    return mysqli_fetch_assoc($result);
}