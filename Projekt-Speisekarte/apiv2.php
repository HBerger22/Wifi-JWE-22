<?php

use WIFI\SK\Model\Speisen;
use WIFI\SK\Model\Getraenke;
use WIFI\SK\Validieren;
use WIFI\SK\Model\Allergene;
use WIFI\SK\Model\BzAllergene;
use WIFI\SK\Model\Kategorien;
use WIFI\SK\Model\Row\Getraenk;

use function WIFI\SK\zwei_kommastellen;
header("Content-Type: application/json");
// session_start();
// if($_SESSION["objekt"]=="Speise"){
//     $objektId="speise_id";
// } else {
//     $objektId="getraenk_id";
// }
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

        // die($datei);
    }
);

// include "adminbereich/setup.php";
include "adminbereich/funktionen.php";
include "adminbereich/config.php";

function fehler($message) {
    header("HTTP/1.1 404 Noot Found");
    // http_response_code(404);
    echo json_encode(array(
      "status" => 0,
      "error" => $message
    ));
    exit;
}

// GET-Parameter aus request_uri entfernen, wird aufgetrennt in ein Array und ich nehme nur den Schlüssel[0] in die $request... als string auf
$request_uri_ohne_get = explode("?", $_SERVER["REQUEST_URI"])[0];

// Aus Anfrage-URI die gewünschte Methode ermitteln
$teile = explode("/api/", $request_uri_ohne_get, 2);
$parameter = explode("/", $teile[1]);




// array_shift entfernt den ersten Wert aus einem Array und gibt ihn zurück
// aus diesem lesen wir hier gleich unsere Version raus.
// ltrim entfernt das 
$api_version = ltrim(array_shift($parameter), "vV");
if (empty($api_version)) {
fehler("Bitte geben Sie eine API-Version an.");
}

// Leere Einträge aus Parameter-Array entfernen
foreach ($parameter as $k => $v) {
if (empty($v)) {
    unset($parameter[$k]);
} else {
    // Alle Parameter in Kleinbuchstaben umwandeln, falls diese falsch daherkommen
    $parameter[$k] = mb_strtolower($v);
}
}
// Indizes neu zuordnen falls mit doppelten Schrägstrichen aufgerufen wird
$parameter = array_values($parameter);

if (empty($parameter)) {
fehler("Nach der Version wurde keine Methode übergeben. Prüfen Sie Ihren Aufruf!");
}  

$speisen = new Speisen();
$alleAktivenSpeisen = $speisen->alleAktivenElemente();

$getraenke = new Getraenke();
$alleAktivenGetraenke =$getraenke->alleAktivenElemente();

$kategorien = new Kategorien();
$alleKategoriern = $kategorien->alleElemente();

// $fehler = new Validieren;

$allergene = new Allergene();
$alleAllergene = $allergene -> alleElemente();

$bzAllergene= new BzAllergene("Speise");
$bzAllergeneGetraenke = new BzAllergene("Getraenk");



$daten=array();
// echo'S_post:';
// echo"<pre>"; //print_r Inhalt aus einem Array darstellen (nur zum debuggen)
// print_r($_POST);
// echo "</pre>";
// echo"<pre>" ;print_r($parameter);


// Ausgabe der verschiedenen Anfragen!!!

// Ausgabe aller existierenden Allergene
if($parameter[0]=="allergene") {
    if(!$alleAllergene){
        fehler("Keine Allergene zum Anzeigen vorhanden");
    } else {
        $ag=array();

        foreach ($alleAllergene as $allergen){

            $ag[]=array(
                "klasse" => $allergen->getSpalte("klasse"),
                "name" => $allergen->getSpalte("name"),
                "beschreibung" => $allergen->getSpalte("beschreibung"),
            );
            
        }
        echo json_encode($ag);
        exit;
    }
}else if($parameter[0]=="speisen") {
    // vorhandenen speisen auflisten 
    if(!$alleAktivenSpeisen){//abfragen ob mind. 1 Speise existiert
        fehler("Keine Speisen zum Anzeigen vorhanden");
    } else {
        $daten = alleSpeisen();         
    }
    echo json_encode($daten);
    exit;
}else if($parameter[0]=="drinks") {
    // vorhandenen Getränke auflisten 
    if(!$alleAktivenGetraenke){//abfragen ob mind. 1 getraenk existiert
        fehler("Keine Getränke zum Anzeigen vorhanden");
    } else {
        $daten = alleDrinks();         
        
    }
    echo json_encode($daten);
    exit;
}else if($parameter[0]=="products") {
    if (empty($parameter[1])) {
        fehler("Nach der Methode wurde keine Sub-Methode übergeben. Prüfen Sie Ihren Aufruf!");
    } else if($parameter[1]=="list"){
        $daten=alleSpeisen();
        $daten=array_merge($daten, alleDrinks());
        echo json_encode($daten);
        exit;
    } else {
        fehler("Nach der Methode wurde eine falsche Sub-Methode/ID übergeben. Prüfen Sie Ihren Aufruf!");
    }
} else if($parameter[0]=="categories"){
    if($parameter[1]=="list"){
        foreach($alleKategoriern as $key=> $kat){
            $daten[$key]["typ"] = $kat->getSpalte("typ");
            $daten[$key]["name"] = $kat->getSpalte("name");
            $daten[$key]["beschreibung"] = $kat->getSpalte("beschreibung");
        }
        echo json_encode($daten);
        exit;        
    } else if(is_int($parameter[1])){
        // überprüfen ob es die Zahl gibt sons fehlermeldung einzelne kat ausgeben
    } else {
        fehler("Nach der Methode wurde eine falsche Sub-Methode/Id übergeben. Prüfen Sie Ihren Aufruf!");
    }
}else {
    fehler("Keine Passende Methode übergeben. Prüfen Sie Ihren Aufruf!");
}
// echo "<br><br>";

// echo'S_daten:';
// echo"<pre>"; //print_r Inhalt aus einem Array darstellen (nur zum debuggen)
// // print_r($daten);
// echo "</pre>";
// if (!$daten){
//     echo " Keine Daten zum anzeigen";
// } else {
//     echo "allergen: ". $daten[0]["allergene"][0]["klasse"];
// }
// echo "<br><br><br><br><br>"; 

function alleSpeisen (){
    global $alleAktivenSpeisen, $bzAllergene, $alleAllergene;
    $daten=array();
        $j=0;
        $vorherigeId="-1";
        foreach ($alleAktivenSpeisen as $speise){
            if($vorherigeId==$speise["speise_id"]){
                // mep hinzufügen zu $daten-Array

                $mep[]=array(
                    "menge" => zwei_kommastellen($speise["menge"]),
                    "eName" => $speise["eName"],
                    "eKuerzel" => $speise["kuerzel"],
                    "preis" => zwei_kommastellen($speise["preis"]) 
                );
            } else if(!empty($mep)) {
                // mep(s) in $daten ablegen
                $daten[$j]["mengeEinheitPreis"]=$mep;
                $j++;
                unset($mep);
            }
            $daten[$j]["sName"]=$speise["sName"];
            $daten[$j]["sBeschreibung"]=$speise["sBeschreibung"];
                
            // Allergene
                $speiseAllergene=$bzAllergene->alleElemente($speise["speise_id"]);

                $ag=array();
                foreach ($alleAllergene as $allergen){
                $vorhanden=false;
                    if($speiseAllergene){
                        foreach ($speiseAllergene as $speiseAllergen){
                            if ($speiseAllergen["allergen_id"] == $allergen->getSpalte("allergen_id")){
                                $vorhanden=true;
                            }
                        }
                    }
                    if ($vorhanden){
                        $aktiv=1; //die speise hat dieses Allergen
                    } else {
                        $aktiv=0;
                    }
                    $ag[]=array(
                        "klasse" => $allergen->getSpalte("klasse"),
                        "name" => $allergen->getSpalte("name"),
                        "beschreibung" => $allergen->getSpalte("beschreibung"),
                        "sBeinhaltetA" => $aktiv
                    );
                    
                }
            $daten[$j]["allergene"]=$ag;

            // Kategorie Einheit Preis Typ 
            $daten[$j]["Typ"] = $speise["typ"];
            $daten[$j]["kName"] = $speise["kName"];
            $daten[$j]["kBeschreibung"] = $speise["kBeschreibung"];

                // $mep=array();
                if(empty($mep)){
                    $mep[]=array(
                        "menge" => $speise["menge"],
                        "eName" => $speise["eName"],
                        "eKuerzel" => $speise["kuerzel"],
                        "preis" => zwei_kommastellen($speise["preis"]) 
                    );
                }

                $vorherigeId=$speise["speise_id"];
        }
        // mep für letzten Datensatz hinzufügen
        $daten[$j]["mengeEinheitPreis"]=$mep;
        return $daten;
}

function alleDrinks(){
    global $alleAktivenGetraenke, $bzAllergeneGetraenke, $alleAllergene ;
    $daten=array();
    $j=0;
    $vorherigeId="-1";
    foreach ($alleAktivenGetraenke as $getraenk){
        if($vorherigeId==$getraenk["getraenk_id"]){
            // mep hinzufügen zu $daten-Array

            $mep[]=array(
                "menge" => zwei_kommastellen($getraenk["menge"]),
                "eName" => $getraenk["eName"],
                "eKuerzel" => $getraenk["kuerzel"],
                "preis" => zwei_kommastellen($getraenk["preis"]) 
            );
        } else if(!empty($mep)) {
            // mep(s) in $daten ablegen
            $daten[$j]["mengeEinheitPreis"]=$mep;
            $j++;
            unset($mep);
        }
        $daten[$j]["gName"]=$getraenk["gName"];
        $daten[$j]["gBeschreibung"]=$getraenk["gBeschreibung"];
            
        // Allergene
            $getraenkAllergene=$bzAllergeneGetraenke->alleElemente($getraenk["getraenk_id"]);

            $ag=array();
            foreach ($alleAllergene as $allergen){
            $vorhanden=false;
                if($getraenkAllergene){
                    foreach ($getraenkAllergene as $getraenkAllergen){
                        if ($getraenkAllergen["allergen_id"] == $allergen->getSpalte("allergen_id")){
                            $vorhanden=true;
                        }
                    }
                }
                if ($vorhanden){
                    $aktiv=1; //die getraenk hat dieses Allergen
                } else {
                    $aktiv=0;
                }
                $ag[]=array(
                    "klasse" => $allergen->getSpalte("klasse"),
                    "name" => $allergen->getSpalte("name"),
                    "beschreibung" => $allergen->getSpalte("beschreibung"),
                    "gBeinhaltetA" => $aktiv
                );
                
            }
        $daten[$j]["allergene"]=$ag;

        // Kategorie Einheit Preis Typ 
        $daten[$j]["Typ"] = $getraenk["typ"];
        $daten[$j]["kName"] = $getraenk["kName"];
        $daten[$j]["kBeschreibung"] = $getraenk["kBeschreibung"];

            // $mep=array();
            if(empty($mep)){
                $mep[]=array(
                    "menge" => zwei_kommastellen($getraenk["menge"]),
                    "eName" => $getraenk["eName"],
                    "eKuerzel" => $getraenk["kuerzel"],
                    "preis" => zwei_kommastellen($getraenk["preis"]) 
                );
            }

            $vorherigeId=$getraenk["getraenk_id"];
    }
    // mep für letzten Datensatz hinzufügen
    $daten[$j]["mengeEinheitPreis"]=$mep;
    return $daten;
}




// Javascript von manuel
// $("#event_list_filter_input").on("keyup", function() {
//     var value = $(this).val().toLowerCase();
//     $("#event_list_rows > .row").filter(function() {
//         $(this).toggle(
//             $(this).text().toLowerCase().indexOf(value) > -1
//         );
//     });
// });