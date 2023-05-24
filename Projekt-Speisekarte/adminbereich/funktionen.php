<?php
namespace WIFI\SK;

// einfache funktion ohne grossartige überprüfung um in einer Zahl das komma gegen einen Punkt zu tauschen.
function punkt_statt_komma($zahl){
    if(stripos($zahl,","))
        $zahl[stripos($zahl,",")]=".";
    return $zahl;
}

// einfache funktion ohne grossartige überprüfung um in einer Zahl den Punkt gegen ein Komma zu tauschen.
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

