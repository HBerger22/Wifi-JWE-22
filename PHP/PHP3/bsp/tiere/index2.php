<h1>Tiere</h1>

<?php

// include "Tier/TierAbstract.php";
// include "Tier/Hund.php";
// include "Tier/Katze.php";
// include "Tier/HundRichtig.php";
// include "Tier/KatzeRichtig.php";
// include "Tier/Maus.php";
// include "Tier/Hund/Dogge.php";

// ich kann die Include datei vergessen wenn ich die folgende Methode verwende
// vorausgesetzt es wurden die Namespaces korrekt verwendet !!!
spl_autoload_register(
    function(string $klasse){
        $basis = __DIR__ ."/"; //Basisverzeichnis __DIR__ ist das Verzeichnis in der die Datei ist. z.B.: C:\XAMPP\HTDOCS\Wifi-JWE-22\PHP\PHP3\bsp\tiere
        $prefix ="WIFI\\JWE\\";
        $laenge =strlen($prefix);
        // wenn die Klasse nicht das gleiche Prefix hat wird abgebrochen (notwendig für fremdprogrammierte eingebundenen code)
        if($prefix !== substr($klasse,0,$laenge)){
            return;
        }

        // Klasse ohne Prefix
        $relativ = substr($klasse,$laenge);

        // Dateipfad erstellen
        $datei = $basis.str_replace("\\","/",$relativ).".php";
        
        // wenn die Datei existiert, einbinden
        if(file_exists($datei)){
            include $datei;
        }

        // die($datei);
    }
);
// der "sql_autoload_register" erhält die Klassennamen (mit Namespaces), die noch nicht includiert wurden
// Diesen können wir in einen Dateipfad umwandeln und die Datei danach einbinden. wird für jede Klasse bei
// ersten Verwendung automatisch aufgerufen.


// use WIFI\JWE\Tier\KatzeRichtig;
// use WIFI\JWE\Tier\HundRichtig;
// use WIFI\JWE\Tier\Maus;
use WIFI\JWE\Tier;
use WIFI\JWE\Tiere;

$hund = new Tier\Hund("Bello");
$katze = new Tier\Katze("Mietzi");
$hund2 = new Tier\HundRichtig("Wuffi");
$katze2 = new Tier\KatzeRichtig("Tom");
$maus = new Tier\Maus("Jerry");
$hund3 = new Tier\Hund\Dogge("Spike");


$tiere = new Tiere();

// hier werden ins objekt Tiere die bereits erzeugten objekte (hund, katze und maus) hinzugefügt.
$tiere->add($hund2);
$tiere->add($katze2);
$tiere->add($maus);
$tiere->add(new Tier\Hund\Dogge("Bully")); //direkter erzeugung eines neuen Tieres beim hinzufügen zu den Tieren

echo $tiere->ausgabe();


// es gibt auch von PHP vordefinierte Interfaces
foreach ($tiere as $tier) {
    echo "<br>";
    echo $tier->getName();
}





