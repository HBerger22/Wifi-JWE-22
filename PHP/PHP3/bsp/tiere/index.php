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


use WIFI\JWE\Tier\KatzeRichtig;
use WIFI\JWE\Tier\HundRichtig;
use WIFI\JWE\Tier\Maus;
use WIFI\JWE\Tier;
// use wird bei Namespaces benötigt um die einzelnen objekte zu erstellen ohne das ich bei jedem new ... den Pfad/Namespace angeben muss.

// $pdf= new \PdfCreator\pdf;

// neues Objekt Hund
$hund = new Tier\Hund("Bello");

echo $hund->getName();
echo "<br>";
echo $hund->gibLaut();

echo "<br>";
echo "<br>";

// Neues Objekt Katze (hat div. teile vom Hund geerbt)
$katze = new Tier\Katze("Mietzi");
echo $katze->getName();
echo "<br>";
echo $katze->gibLaut();

echo "<br>";
echo "<br>";


// katze wird von Hund abgeleitet was keinen Sinn macht --> 
// deshalb erstellung der abstrakten TierAbstract Klasse
$hund2 = new HundRichtig("Wuffi");

echo $hund2->getName();
echo "<br>";
echo $hund2->gibLaut();

echo "<br>";
echo "<br>";



$katze2 = new KatzeRichtig("Tom");


echo $katze2->getName();
echo "<br>";
echo $katze2->gibLaut();

echo "<br>";
echo "<br>";

$maus = new Maus("Jerry");
echo $maus->getName();
echo "<br>";
echo $maus->gibLaut();

//protected kann von aussen nicht zugeriffen werden
echo "<br>";
echo "<br>";

$hund3 = new Tier\Hund\Dogge("Spike");
echo $hund3->getName();
echo "<br>";
echo $hund3->gibLaut();

echo "<br>";
echo "<br>";


use WIFI\JWE\Tiere;
$tiere = new Tiere();





// man kann überprüfen ob ein objekt eine Instanz einer bestimmten Klasse oder abstracten Klasse ist
if($katze instanceof Tier\Katze){

}