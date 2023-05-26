<?php
header("refresh:5; index_monitor.php");
session_start();
if(empty($_SESSION["typ"])){
    $_SESSION["typ"]="speise";
    $_SESSION["index"]=0;
    // echo $_SESSION["typ"].$_SESSION["index"];
}
// echo $_SESSION["typ"].$_SESSION["index"];
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="css/style_monitor.css">
    <!-- <link rel="stylesheet" href="css/slider.css">
    <link rel="stylesheet" href="css/checkbox.css"> -->
    <title>U-Keller - Speisekarte</title>
</head>
<body>
    <div id="innerWrapper">
        <header>   
            <h1>Unsere Karte </h1>
        </header>
        <main>

<?php

use WIFI\SK\Model\Getraenke;
use WIFI\SK\Model\Speisen;
include "adminbereich/config.php";
include "adminbereich/funktionen.php";

spl_autoload_register(
    function(string $klasse){
        // Basisverzeichnis für das Namespace Prefix
        $basis = __DIR__ ."/adminbereich/classes/"; //Basisverzeichnis __DIR__ ist das Verzeichnis in der die Datei ist. z.B.: C:\XAMPP\HTDOCS\Wifi-JWE-22\PHP\PHP3\projekt\admin

        // Projekt-spezifisches namespace prefix
        $prefix ="WIFI\\SK\\";// \Fdb, weil die klassen in diesem Unterordner sind
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

$speisen= new Speisen();
$alleSpeisen= $speisen -> alleElementeMitKatMep();

$getraenke = new Getraenke();
$alleGetraenke = $getraenke ->alleElementeMitKatMep();

$html=array();

$kname="";     // KategorieName
$zaehler=0;    // Zähler für die verschiedenen Farben der Kategorien
$divZaehler=0; // Zähler für die <div> elemente

$htmlInhalt="<div>";
$zeichenProDiv=1050; //anzahl der zeichen im $htmlInhalt bevor ein neuer Div Tag erzeugt wird 

// verarbeitung der Speisen
    foreach($alleSpeisen as $entry ){
        // sorgt dafür das es ab mehr als 1100 Zeichen ein neues Div element gibt und die Kategorie in jedem 3. Div (beginnend ab Div4) noch vorangestellt wird.
        if (strlen($htmlInhalt) > $zeichenProDiv){
            $htmlInhalt.="</div>";
            $html[]=$htmlInhalt;
            $htmlInhalt = "<div>";
            $divZaehler++;
            if($divZaehler%3 == 0 && $kname==$entry["kName"]){
                $htmlInhalt .= "<button id='s{$zaehler}'>{$entry["kName"]}</button>";
            }
        }

    	// kategorie (Vorspeise, Hauptspeise, ...)
        if($kname!=$entry["kName"]){
            if($kname!=""){   
                $htmlInhalt.="</ul>";
            }
            $zaehler+=1;
            $htmlInhalt.= "\n" . "
            <button id='s{$zaehler}'>{$entry["kName"]}</button>
            <ul id='s{$zaehler}u'>";
        }

        // einzelnen gerichte
        // vorbereitung Allergene
        $alText="";
        // $alKlasse="";
        foreach($entry["allergene"] as $indexA => $entryA ) {
            if($entry["allergene"][$indexA]["pBeinhaltetA"]==1){
                if ($alText==""){
                    $alText="(". $entryA["klasse"];
                } else {
                    $alText.=",". $entryA["klasse"];                        
                }
            }
        };
        if($alText!=""){
            $alText.=" *)";
        }

        // html ausgabe
        $htmlInhalt.= "\n " ."        
        <li> 
            <h3 class='produkt'> {$entry["Name"]} </h3> 
            <div class='details'> {$entry["Beschreibung"]} {$alText}</div>";
            // mehrere MEPs? (Menge/Einheit/Preise)
            foreach($entry["mengeEinheitPreis"] as $indexMep => $entryMep) {
                $htmlInhalt.="
                <div class='preiseinheit'>
                    <div class='einheit' > {$entryMep["menge"]} {$entryMep["eKuerzel"]} </div>
                    <div class='preis'>€ {$entryMep["preis"]}</div> 
                </div>";
            };            
        $htmlInhalt.="</li>";
        $kname=$entry["kName"];
    };
    $htmlInhalt.= "</ul>";
    $htmlInhalt.="</div>";
    $html[]=$htmlInhalt;

// verarbeitung der Getränke
$kname="";     // KategorieName
$zaehler=1;    // Zähler für die verschiedenen Farben der Kategorien
$divZaehler=0; //Zähler für die <div> elemente
$htmlG=array();
$htmlInhalt="<div>";

    foreach($alleGetraenke as $entry ){
        // sorgt dafür das es ab mehr als 1100 Zeichen ein neues Div element gibt und die Kategorie in jedem 3. Div (beginnend ab Div4) noch vorangestellt wird.
        if (strlen($htmlInhalt) > $zeichenProDiv){
            $htmlInhalt.="</div>";
            $htmlG[]=$htmlInhalt;
            $htmlInhalt = "<div>";
            $divZaehler++;
            if($divZaehler%3 == 0){
                $htmlInhalt .= "<button id='s{$zaehler}'>{$entry["kName"]}</button>";
            }
        }

    	// kategorie (Vorspeise, Hauptspeise, ...)
        if($kname!=$entry["kName"]){
            if($kname!=""){   
                $htmlInhalt.="</ul>";
            }
            $zaehler+=1;
            $htmlInhalt.= "\n" . "
            <button id='s{$zaehler}'>{$entry["kName"]}</button>
            <ul id='s{$zaehler}u'>";
        }

        // einzelnen gerichte
        // vorbereitung Allergene
        $alText="";
        // $alKlasse="";
        foreach($entry["allergene"] as $indexA => $entryA ) {
            if($entry["allergene"][$indexA]["pBeinhaltetA"]==1){
                if ($alText==""){
                    $alText="(". $entryA["klasse"];
                } else {
                    $alText.=",". $entryA["klasse"];                        
                }
                    // $alKlasse+= ` c_al_${entryA["klasse"]} `;
            }
        };
        if($alText!=""){
            $alText.=" *)";
        }

        // html ausgabe
        $htmlInhalt.= "\n " ."        
        <li> 
            <h3 class='produkt'> {$entry["Name"]} </h3> 
            <div class='details'> {$entry["Beschreibung"]} {$alText}</div>";
            // mehrere MEPs? (Menge/Einheit/Preise)
            foreach($entry["mengeEinheitPreis"] as $indexMep => $entryMep) {
                $htmlInhalt.="
                <div class='preiseinheit'>
                    <div class='einheit' > {$entryMep["menge"]} {$entryMep["eKuerzel"]} </div>
                    <div class='preis'>€ {$entryMep["preis"]}</div> 
                </div>";
            };
        $htmlInhalt.="</li>";
        $kname=$entry["kName"];
    };
    $htmlInhalt.= "</ul>";
    $htmlInhalt.="</div>";
    $htmlG[]=$htmlInhalt;

    // echo $html[0];
    // echo $html[1];
    // echo $html[2];
    // echo $html[3];
    // echo $html[4];
    // echo $html[5];
    // echo $htmlG[0];
    // echo $html[7];
    // echo $html[8];


    if($_SESSION["typ"]=="speise"){
        // echo "Speise ".count($html) ." ". $_SESSION["index"];
        if (count($html)>$_SESSION["index"]){
            echo $html[$_SESSION["index"]];
            if(!empty($html[$_SESSION["index"]+1]))
                echo $html[$_SESSION["index"]+1];
            if(!empty($html[$_SESSION["index"]+2]))
                echo $html[$_SESSION["index"]+2];
            $_SESSION["index"]+=3;
        } else {
            $_SESSION["typ"]="getraenk";
            echo $htmlG[0];
            if(!empty($htmlG[1]))
                echo $htmlG[1];
            if(!empty($htmlG[2]))
                echo $htmlG[2];
            $_SESSION["index"]=3;
        }
    } else {
        if (count($htmlG)>$_SESSION["index"]+1){
            echo $htmlG[$_SESSION["index"]];
            if(!empty($htmlG[$_SESSION["index"]+1]))
                echo $htmlG[$_SESSION["index"]+1];
            if(!empty($htmlG[$_SESSION["index"]+2]))
                echo $htmlG[$_SESSION["index"]+2];
            $_SESSION["index"]+=3;
        } else {
            $_SESSION["typ"]="speise";
            
            echo $html[0];
            if(!empty($html[1]))
                echo $html[1];
            if(!empty($html[2]))
                echo $html[2];
            $_SESSION["index"]=3;
        }
    }

?>
        </main>

        <footer>
            <!-- <a href="resourcen/Liste-der-14-Allergene.pdf">* Allergene Übersicht</a>  -->
            <div> Alle Preise in € inkl. gesetzlicher Mwst. 
                Copyright 2023
            </div>
        </footer>
    </div>
</body>
</html>