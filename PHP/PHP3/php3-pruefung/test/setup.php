<?php
namespace WIFI\Schiff;

spl_autoload_register(
    function(string $klasse){
        // Basisverzeichnis für das Namespace Prefix
        $basis = __DIR__ ."/"; //Basisverzeichnis __DIR__ ist das Verzeichnis in der die Datei ist. z.B.: C:\XAMPP\HTDOCS\Wifi-JWE-22\PHP\PHP3\projekt\admin

        // Projekt-spezifisches namespace prefix
        $prefix ="WIFI\\Schiff\\";// \Fdb, weil die klassen in diesem Unterordner sind
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
