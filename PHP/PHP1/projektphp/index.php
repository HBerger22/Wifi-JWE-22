<?php
// Die Aufgabe ist die bestehenden Homepage von HTML ins PHP zu übertragen.
// $seite="home";
if ( empty($_GET["seite"])){
    $seite ="home";
} else {
    $seite = $_GET["seite"];
}

if($seite == "home"){
    $include_datei="home.php";
    $seitentitel='Der Friseur ums Eck';
    $meta_description="Friseur";
}elseif ($seite == "kontakt"){
    $include_datei="kontakt.php";
    $seitentitel="Fragen sie Uns";
    $meta_description="Kontakt";
}elseif ($seite == "oeffnungszeiten"){
    $include_datei="oeffnungszeiten.php";
    $seitentitel="Unsere Öffnunszeiten";
    $meta_description="Oeffnungszeiten";
}elseif ($seite == "leistungen"){
    $include_datei="leistungen.php";
    $seitentitel="Unsere Leistungen";
    $meta_description="Leistungen";
} else {
    // 404
    $include_datei="error404.php";
    $seitentitel="Tja da ist was falsch gelaufen, ...";
    $meta_description="Achtung es ist ein Fehler aufgetreten.";
};

include ("kopf.php");
include ("inhalte/".$include_datei);
include ("fuss.php");






