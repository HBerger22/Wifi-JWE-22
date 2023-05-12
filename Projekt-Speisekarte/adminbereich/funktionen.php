<?php
namespace WIFI\SK;
// session_start();

// if(empty($_SESSION["login"])){
//     // kein benutzer eingeloggt --> umleiten zum login
//     header("location: login.php");
//     exit; //mit header wird auf eine andere Seite umgeleitet und mit Exit wird das aktuelle script beendet
// }

// $con= @new mysqli("","root","","speisekarte"); //Das @ bedeutet silent und unterdrückt die ausgabe von Fehlermeldungen (notwendig gegen Hackerangriffe die sonst eine Info zur DB bekommen würden)

// // $con= @new mysqli("localhost","jwe_bh","6td4t~O1jZ75f5@e","obinet_jwe_bh_db1"); //Das @ bedeutet silent und unterdrückt die ausgabe von Fehlermeldungen (notwendig gegen Hackerangriffe die sonst eine Info zur DB bekommen würden)

//     if($con->connect_error){
//         exit("Fehler beim Verbindungsaufbau");
//     };

// einfache funktion ohne grossartige überprüfung um in einer Zahl das komma gegen einen Punkt zu tauschen.
function punkt_statt_komma($zahl){
    if(stripos($zahl,","))
        $zahl[stripos($zahl,",")]=".";
    return $zahl;
}

function komma_statt_punkt($zahl){
    if(stripos($zahl,".")){
        $zahl.=""; //in text umwandeln sonst funkts nicht
        $zahl[stripos($zahl,".")]=",";
    }
    return $zahl;
}

// function zum umwandeln der Zahl aus der DB in eine gleit"komma"darstellung mit 2 Kommastellen
function zwei_kommastellen($zahl){
    if(strpos($zahl,".")){
        if(strlen($zahl)-strpos($zahl,".")<3){
            $zahl=komma_statt_punkt($zahl.="0");
        } else {
            $zahl=komma_statt_punkt($zahl);
        }
    } else {
        $zahl.=",00";
    }
    return $zahl;
}



// allgemeine Funktionen zur kürzeren Schreibweise für den DB zugriff.
// kurzform für: mysqli_real_escape_string($db, $wort)
// function escape ($wort){
//     global $con;
//     return mysqli_real_escape_string($con, $wort);
// }

// Kurzform für: mysqli_query($db,$statement);
// function query ($statement){
//     global $con;
//     $result = mysqli_query($con,$statement) or die(mysqli_error($con)."<br>".$statement);
//     return $result;
// }

// kurzform für: mysqli_fetch_assoc($result);
// function fetch ($result){
//     return mysqli_fetch_assoc($result);
// }

