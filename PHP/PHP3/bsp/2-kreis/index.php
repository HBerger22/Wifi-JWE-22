<h1>Kreis</h1>

<?php

include "Kreis.php";

$k = new Kreis(3);
$k2 = new Kreis(30);

echo "Fläche: ".$k->flaeche() ."<br>";
echo "PI aus der Klasse: ".Kreis::PI . "<br>";

echo "Durchmesser: ".$k->durchmesser() ."<br>";

echo "Umfang: ".$k->umfang() ."<br>";

$k-> setRadius(5);

echo "Durchmesser neu: ".$k->durchmesser() ."<br>";



// auffangen von throw Fehlermeldungen
$benutzer_eingabe = -2;
try{
    // div befehle
    $k -> setRadius($benutzer_eingabe);
    echo "Durchmesser zum Schluss: ".$k->durchmesser() ."<br>";
} catch (Exception $except) { //fange fehler vom Typ Exception auf und speichere sie als objekt (vom der klasse exception von PHP vorgegeben) 
        // in die variable $except. Es kann auch mehrere Catches für unterschiedliche Exceptions geben. (z.B.: wrongValueException, ...)
    echo " da ist was schiefgegangen: ". $except->getMessage() ."<br>";
} finally {
    echo "Dieser Code wird immer ausgeführt. <br>";
}

// unset ($k);

echo "Letzte Meldung! <br>";