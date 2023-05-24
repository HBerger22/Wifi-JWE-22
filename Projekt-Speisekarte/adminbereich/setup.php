<?php


// Setup Code: nur verändern wenn du weißt was du tust!!!

// Man kann die Include datei vergessen wenn man die folgende Methode verwende
// vorausgesetzt es wurden die Namespaces korrekt verwendet !!!

session_start();
include "config.php";

if(empty($_SESSION["login"])){
    // kein benutzer eingeloggt --> umleiten zum login
    header("location: login.php");
    exit; //mit header wird auf eine andere Seite umgeleitet und mit Exit wird das aktuelle script beendet
}

spl_autoload_register(
    function(string $klasse){
        // Basisverzeichnis für das Namespace Prefix
        $basis = __DIR__ ."/classes/"; //Basisverzeichnis __DIR__ ist das Verzeichnis in der die Datei ist. z.B.: C:\XAMPP\HTDOCS\Wifi-JWE-22\PHP\PHP3\projekt\admin

        // Projekt-spezifisches namespace prefix
        $prefix ="WIFI\\SK\\"; //  weil die klassen in diesem Unterordner sind
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
    }
);