
<?php

use WIFI\SK\Model\Kategorien;
use WIFI\SK\Model\Row\Kat;
use WIFI\SK\Validieren;

include "setup.php";

include "kopf.php";

echo "<h1>Kategorien</h1>";
echo "<p>Hier haben sie eine Übersicht über die vorhandenen Kategorien.</p>";

// neues Objekt mit allen kategorien anlegen
$kategorien = new Kategorien();
$alleElemente = $kategorien-> alleElemente();   

$fehler = new Validieren;

if(!empty($_SESSION["erfolg"])){
    echo "<p style='color:green'>".$_SESSION["erfolg"]."</p>";
    unset($_SESSION["erfolg"]);
}
if(!empty($_SESSION["fehlermeldung"])){
    echo "<p style='color:red'>".$_SESSION["fehlermeldung"]."</p>";
    unset($_SESSION["fehlermeldung"]);
}
unset($_SESSION["k_bearbeiten"]);

// Artikel bearbeiten

if(!empty($_POST["k_bearbeiten"])){
    $_SESSION["k_bearbeiten"]=$_POST["k_bearbeiten"];
    header("location: kategorie_aendern.php");
    exit();
}

// Kategorie hinzufügen
if(!empty($_POST["hinzu"])){
    header("location: kategorie_aendern.php");
    exit();
}

// endgültig löschen //!!!!! Überprüfung ob noch eine Verknüpfung zu speisen - Getränke besteht
if(!empty($_POST["k_loeschen"]) || !empty($_POST["k_loeschen_bestaetigung"])){
    if(!empty($_POST["k_loeschen"])){
        $_SESSION["k_loeschen"]=$_POST["k_loeschen"]; //übergabe der id von $Post an $session
    }

    // Abfrage ob es zu dieser Einheit noch eine Verknüpfung zu einer Speise gibt
    $kat = new Kat($_SESSION["k_loeschen"]);
    
    if(!$kat -> existiertVerbindung()){//abfragen ob es noch eine Verknüpfung zu einer Speise gibt
        $fehler -> fehlerDazu("Es existiert noch eine Verknüpfung mit dieser Kategorie zu einer Speise! <br>
            Bitte löschen sie vorher die zugehörige/n Speisen!");
            unset($_POST["k_loeschen"]);
    } else {

        if(empty($_POST["k_loeschen_bestaetigung"]) ){
            echo "<p style='color:red'>??? Wollen sie die ausgewählte Kategorie wirklich endgültig löschen: ???<br> <strong>{$kat -> getSpalte("name")}</strong></p>";
            echo "<form method='post'>";
                    echo '<button class="sub_buttons" type="submit" name="k_loeschen_bestaetigung" value="1">JA</button>';
                    echo '<button class="sub_buttons" type="submit" name="k_loeschen_bestaetigung" value="0">NEIN</button>';
            echo "</form>";
        } else {
            if($_POST["k_loeschen_bestaetigung"] == 1 ){
                $erfolg= "!!! Kategorie erfolgreich gelöscht !!!";
                $kat -> datensatzLoeschen();
                $alleElemente = $kategorien-> alleElemente();   //daten aktuallisieren
                unset($_SESSION["k_loeschen"]);
                unset($_POST["k_loeschen_bestaetigung"]);
            }
        }
    }
}

// einzelne Kategorieren Aktivieren/deaktivieren mithilfe der versteckten Checkboxen cbid in der die ID gespeichert ist und session[num_rows].
if(!empty($_POST["aktivieren"])){
    foreach ($alleElemente as $kategorie){
        if (!empty($_POST["cb".$kategorie->getSpalte("kategorie_id")])){
            $kategorie -> akDeak(1);
        } else {
            $kategorie -> akDeak(0);
        }        
    }
    $alleElemente = $kategorien-> alleElemente();     //Daten Aktualisieren  
}

if(!empty($erfolg)){
    echo "<p style='color:green'>".$erfolg."</p>";
}

if($fehler->fehlerAufgetreten()){
    echo "<p style='color:red'>".$fehler -> fehlerAusgabeHtml() ."</p>";
    unset($fehler);
}

// vorhandenen Kategorien auflisten 
if(empty($_POST["k_loeschen"]) && empty($_POST["k_loeschen_bestaetigung"])){

        echo "<form method='post'>";
            echo '<button class="sub_buttons" type="submit" name="hinzu" value="1">Kategorie hinzufügen</button>';
            if(!$alleElemente){//abfragen ob Kategorien existieren
                $fehler -> fehlerDazu("Keine Kategorie zum anzeigen vorhanden!");
            } else {
                //setzen der gesamtanzahl an zeilen damit beim aktiv/deaktiv. alle Menupunkte durchlaufen werden.
                    echo '<button class="sub_buttons" type="submit" name="aktivieren" value="1">Aktivieren/deaktivieren</button>';

                    echo "<table border='1'>";
                        echo "<thead>";
                            echo "<th> Aktiv </th> "; 
                            echo "<th> bearbeiten </th> ";   
                            echo "<th> löschen </th> ";
                            echo "<th> Typ </th> ";
                            echo "<th> Name </th> ";
                            echo "<th> Beschreibung </th> ";
                        echo "<thead>";
                        echo "<tbody>"; 
                            foreach ($alleElemente as $kategorie){
                                if($kategorie->getSpalte("aktiv")=="1"){
                                    $checkb="<input type='checkbox' name='cb{$kategorie->getSpalte("kategorie_id")}' value='{$kategorie->getSpalte("kategorie_id")}' checked>";
                                    $bgcolor="green";
                                } else {
                                    $checkb="<input type='checkbox' name='cb{$kategorie->getSpalte("kategorie_id")}' value='{$kategorie->getSpalte("kategorie_id")}'>";
                                    $bgcolor="red";
                                }
                                echo "<tr>";
                                    echo "<td align='center' style='background-color: {$bgcolor}'>" . $checkb. "</td>";
                                    echo "<td align='center'>" . 
                                        '<button class="mini_buttons" type="submit" name="k_bearbeiten" value="'.$kategorie->getSpalte("kategorie_id").'">b</button>' 
                                        . "</td>";
                                    echo "<td align='center'>" . 
                                        '<button class="mini_buttons" type="submit" name="k_loeschen" value="'.$kategorie->getSpalte("kategorie_id").'">l</button>' 
                                        . "</td>";
                                    echo "<td align='center'>" . $kategorie->getSpalte("typ"). "</td>";
                                    echo "<td align='center'>" . $kategorie->getSpalte("name"). "</td>";
                                    echo "<td align='center'>" . $kategorie->getSpalte("beschreibung"). "</td>";
                                echo "</tr> ";
                            }
                        echo "</tbody>";
                    echo "</table border='1'>";
            }
        echo "</form>";
    // }
}

if(!empty($fehler)){
    echo "<p style='color:red'>".$fehler -> fehlerAusgabeHtml() ."</p>";
    unset($fehler);
}
include "fuss.php";