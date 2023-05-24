
<?php

use WIFI\SK\Validieren;
use WIFI\SK\Model\Allergene;
use WIFI\SK\Model\Row\Allergen;

include "setup.php";

include "kopf.php";

echo "<h1>Allergene</h1>";
echo "<p>Hier haben sie eine Übersicht über die vorhandenen Allergene.</p>";

$allergene = new Allergene();
$alleElemente = $allergene -> alleElemente();

$fehler = new Validieren();


if(!empty($_SESSION["erfolg"])){
    echo "<p style='color:green'>".$_SESSION["erfolg"]."</p>";
    unset($_SESSION["erfolg"]);
}
if(!empty($_SESSION["fehlermeldung"])){
    echo "<p style='color:red'>".$_SESSION["fehlermeldung"]."</p>";
    unset($_SESSION["fehlermeldung"]);
}

// Allergen bearbeiten
if(!empty($_POST["a_bearbeiten"])){
    $_SESSION["a_bearbeiten"]=$_POST["a_bearbeiten"];
    header("location: allergen_aendern.php");
    exit();
}

// allergen hinzufügen
if(!empty($_POST["hinzu"])){
    header("location: allergen_aendern.php");
    exit();
}

// löschen 
if(!empty($_POST["a_loeschen"]) || !empty($_POST["a_loeschen_bestaetigung"])){
    if(!empty($_POST["a_loeschen"])){
        $_SESSION["a_loeschen"]=($_POST["a_loeschen"]); //übergabe der id von $Post an $session
    }
    
    // Abfrage ob es zu dieser Einheit noch eine Verknüpfung zu einer Speise gibt
    $allergen = new Allergen($_SESSION["a_loeschen"]);
    if(!$allergen -> existiertVerbindung() ){//abfragen ob es noch eine Verknüpfung zu einer Speise gibt
        $fehler-> fehlerdazu("Es existiert noch eine Verknüpfung mit dieser Einheit zu einer Speise! <br>
            Bitte löschen sie vorher die zugehörige/n Speisen!");
            unset($_POST["a_loeschen"]);
    } else {
        if(empty($_POST["a_loeschen_bestaetigung"]) ){
            echo "<p style='color:red'>??? Wollen sie die ausgewählte Einheit wirklich endgültig löschen: ???<br> <strong>{$allergen->getSpalte("name")}</strong></p>";
            echo "<form method='post'>";
                    echo '<button class="sub_buttons" type="submit" name="a_loeschen_bestaetigung" value="1">JA</button>';
                    echo '<button class="sub_buttons" type="submit" name="a_loeschen_bestaetigung" value="0">NEIN</button>';
            echo "</form>";
        } else {
            if($_POST["a_loeschen_bestaetigung"] == 1 ){
                $erfolg= "!!! Einheit erfolgreich gelöscht !!!";
                $allergen -> datensatzLoeschen();
                $alleElemente = $allergene -> alleElemente(); //Daten Aktuallisieren
                unset($_SESSION["a_loeschen"]);
                unset($_POST["a_loeschen_bestaetigung"]);
            }
        }
    }
}

if(!empty($erfolg)){
    echo "<p style='color:green'>".$erfolg."</p>";
}
if($fehler->fehlerAufgetreten()){
    echo "<p style='color:red'>".$fehler->fehlerAusgabeHtml()."</p>";
    unset($fehler);
}

// vorhandenen Einheiten auflisten 
if(empty($_POST["a_loeschen"]) && empty($_POST["a_loeschen_bestaetigung"])){

    echo "<form method='post'>";
        echo '<button class="sub_buttons" type="submit" name="hinzu" value="1">Allergen hinzufügen</button>';
        if(!$alleElemente){//abfragen Einheiten existieren
            
            $fehler -> fehlerDazu("Kein Allergen zum anzeigen vorhanden!");
        } else {
                echo "<table border='1'>";
                    echo "<thead>";
                        echo "<th> bearbeiten </th> ";   
                        echo "<th> löschen </th> ";
                        echo "<th> Klasse</th> ";
                        echo "<th> Name </th> ";
                        echo "<th> Beschreibung </th> ";
                    echo "<thead>";
                    echo "<tbody>"; 
                        foreach ($alleElemente as $allergen){
                            echo "<tr>";
                                echo "<td align='center'>" . 
                                    '<button class="mini_buttons" type="submit" name="a_bearbeiten" value="'.$allergen->getSpalte("allergen_id").'">b</button>' 
                                    . "</td>";
                                echo "<td align='center'>" . 
                                    '<button class="mini_buttons" type="submit" name="a_loeschen" value="'.$allergen->getSpalte("allergen_id").'">l</button>' 
                                    . "</td>";
                                echo "<td align='center'>" . $allergen->getSpalte("klasse"). "</td>";
                                echo "<td align='center'>" . $allergen->getSpalte("name"). "</td>";
                                echo "<td align='center'>" . $allergen->getSpalte("beschreibung"). "</td>";
                            echo "</tr> ";
                        }
                    echo "</tbody>";
                echo "</table border='1'>";
        }
        echo "</form>";
}

if(!empty($fehler)){
    echo "<p style='color:red'>".$fehler -> fehlerAusgabeHtml() ."</p>";
    unset($fehler);
}

include "fuss.php";