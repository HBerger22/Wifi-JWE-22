<?php
namespace WIFI\SK;

use WIFI\SK\Model\Row\Speise;
use WIFI\SK\Model\Speisen;
use WIFI\SK\Validieren;
use WIFI\SK\Model\Allergene;
use WIFI\SK\Model\BzAllergene;
use WIFI\SK\Model\BzKatEinheit;

use function WIFI\SK\zwei_kommastellen;

include "setup.php";
include "funktionen.php";


echo "<h1>API</h1>";

$speisen = new Speisen();
$alleSpeisen = $speisen -> alleElemente();

$fehler = new Validieren;

$allergene = new Allergene();
$alleAllergene = $allergene -> alleElemente();

$bzAllergene= new BzAllergene;
$bzKatEinheit = new BzKatEinheit;

// $db = Mysql::getInstanz();

// echo'AlleAktivenSpeisen: ';
// echo"<pre>"; //print_r Inhalt aus einem Array darstellen (nur zum debuggen)
// print_r($alleAktivenSpeisen);
// echo "</pre>";
// echo'S_post:';
// echo"<pre>"; //print_r Inhalt aus einem Array darstellen (nur zum debuggen)
// print_r($_POST);
// echo "</pre>";

// vorhandenen speisen auflisten 
    if(!$alleSpeisen){//abfragen ob mind. 1 Speise existiert
        $fehler->fehlerDazu("Keine Speisen zum anzeigen vorhanden!");
    } else {
                    // echo "<th colspan='".count($alleAllergene)."'>Allergene</th>";
                    // echo "<th colspan='2'> Kategorie </th> ";
                    // echo "<th colspan='5'> MEP = Menge/Einheit/Preis </th> ";

                    // echo "<th> Name </th> ";
                    // echo "<th> Beschreibung </th> ";
                    // //Die Allergenklassen abrufen
                    // foreach ($alleAllergene as $allergen){
                    //     echo "<th> {$allergen->getSpalte("klasse")} </th> ";
                    // }
                    // echo "<th> Aktiv </th> ";
                    // echo "<th> Name </th> ";
                    // echo "<th> MEP bearbeiten </th> ";
                    // echo "<th> Aktiv </th> ";
                    // echo "<th> Menge </th> ";
                    // echo "<th> Einheit </th> ";
                    // echo "<th> Preis </th> ";
                    $daten=array();
                    $j=0;
                    foreach ($alleSpeisen as $speise){

                        // if($speise->getSpalte("aktiv")==1)
                        // {
                        
                            // Abfragen der zugehörigen Kategorie (und eventuell einheit)
                            // ist keine Kategorie zugeordnet worden soll leer stehen
                            
                            // Abfragen der zugehörigen  einheit
                            // ist keine einheit zugeordnet worden soll leer stehen

                            $daten[$j]["sName"]=$speise->getSpalte("name");
                            $daten[$j]["sBeschreibung"]=$speise->getSpalte("beschreibung");

                            
                            // Allergene
                                $speiseAllergene=$bzAllergene->alleElemente($speise->getSpalte("speise_id"));

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
                                $speiseKat=$bzKatEinheit->zugehörigeKat($speise->getSpalte("speise_id"));
                                $speiseEinheit=$bzKatEinheit->zugehörigeEinhMengePreis($speise->getSpalte("speise_id"));                            

                            $daten[$j]["Typ"] = $speiseKat[0]["typ"]. "</td>";
                            $daten[$j]["kName"] = $speiseKat[0]["kname"]. "</td>";
                            $daten[$j]["kBeschreibung"] = $speiseKat[0]["beschreibung"]. "</td>";

                                $mep=array();

                                if ($speiseEinheit){

                                //Menge Einheit Preis (notwendig falls mehrere einheiten Mengen vorhanden sind)
                                    for($i=0;$i<count($speiseEinheit);$i++){
                                        $mep[]=array(
                                            "menge" => zwei_kommastellen($speiseEinheit[$i]["menge"]),
                                            "eName" => $speiseEinheit[$i]["ename"],
                                            "eKuerzel" => $speiseEinheit[$i]["kuerzel"],
                                            "preis" => zwei_kommastellen($speiseEinheit[$i]["preis"]) 
                                        );
                                    } 
                                } else {   
                                    $mep[]=array(
                                        "menge" => "na",
                                        "eName" => "na",
                                        "eKuerzel" => "na",
                                        "preis" => "na" 
                                    );
                                }
                            $daten[$j]["mengeEinheitPreis"]=$mep;
                        $j++;
                    }
        
    }
    
echo'S_daten:';
echo"<pre>"; //print_r Inhalt aus einem Array darstellen (nur zum debuggen)
print_r($daten);
echo "</pre>";
echo "allergen: ". $daten[0]["allergene"][0]["klasse"];
echo "<br><br><br><br><br>"; 