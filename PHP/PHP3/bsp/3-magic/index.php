<h1>Magische Methoden</h1>
<?php

ini_set("error_reporting",E_ALL);


include "Magic.php";

// magic Method __set()
$m = new Magic();
$m -> vorname= "Markus";
$m -> nachname= "Hauser";

// echo "<pre>";
// print_r($m);
// echo "</pre>";


// magic Method __get();
echo $m->vorname."<br>";
echo $m->nachname."<br>";

// magic Method __call();
$m->supermethode("klafjlö","ljsalk","Benutzer",5,6,8,1,6);
$m->speichern("benutzer","Passwort","5");

// magic Method __toString()
echo "<pre>";
echo $m;
echo "</pre>";