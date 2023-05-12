<?php

use WIFI\SK\Model\Speisen;
use WIFI\SK\Validieren;
use WIFI\SK\Model\Allergene;
use WIFI\SK\Model\BzAllergene;

use function WIFI\SK\zwei_kommastellen;

include "setup.php";
include "funktionen.php";

echo "<h1>API</h1>";

$speisen = new Speisen();
$alleAktivenSpeisen = $speisen->alleAktiveElemente();

$fehler = new Validieren;

$allergene = new Allergene();
$alleAllergene = $allergene -> alleElemente();

$bzAllergene= new BzAllergene;
// echo'S_post:';
// echo"<pre>"; //print_r Inhalt aus einem Array darstellen (nur zum debuggen)
// print_r($_POST);
// echo "</pre>";

// vorhandenen speisen auflisten 
    if(!$alleAktivenSpeisen){//abfragen ob mind. 1 Speise existiert
        $daten=false;
    } else {
                    
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
                    "preeis" => zwei_kommastellen($speise["preis"]) 
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
            $daten[$j]["Typ"] = $speise["typ"]. "</td>";
            $daten[$j]["kName"] = $speise["kName"]. "</td>";
            $daten[$j]["kBeschreibung"] = $speise["kBeschreibung"]. "</td>";

                // $mep=array();
                if(empty($mep)){
                    $mep[]=array(
                        "menge" => zwei_kommastellen($speise["menge"]),
                        "eName" => $speise["eName"],
                        "eKuerzel" => $speise["kuerzel"],
                        "preis" => zwei_kommastellen($speise["preis"]) 
                    );
                }

                $vorherigeId=$speise["speise_id"];
        }
        // mep für letzten Datensatz hinzufügen
        $daten[$j]["mengeEinheitPreis"]=$mep;
        
    }
echo'S_daten:';
echo"<pre>"; //print_r Inhalt aus einem Array darstellen (nur zum debuggen)
print_r($daten);
echo "</pre>";
if (!$daten){
    echo " Keine Daten zum anzeigen";
} else {
    echo "allergen: ". $daten[0]["allergene"][0]["klasse"];
}
echo "<br><br><br><br><br>"; 