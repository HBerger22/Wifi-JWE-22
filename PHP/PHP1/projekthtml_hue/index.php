<?php

if($_GET['seite']!=null){
    $seite=$_GET['seite'];
} else {
    $seite='home';
}

if($seite=="home"){
    $titel="Der Friseur mit Hirn";
} else if($seite=="leistungen"){
    $titel="Unsere Leistungen";
}else if($seite=="oeffnungszeiten"){
    $titel="Wir haben für sie offen";
}else if($seite=="kontakt"){
    $titel="Sie wollen uns kontaktieren?";
} else { //404
    $seite="err404";
    $titel="Sie wollen uns kontaktieren?";
}





include ("inhalt/kopf.php");
include ("inhalt/$seite.php");


include ("inhalt/fuss.php");






?>