
<?php

use WIFI\SK\Validieren;
use WIFI\SK\Model\Einheiten;
use WIFI\SK\Model\Row\Einheit;

include "setup.php";

include "kopf.php";

echo "<h1>Einheiten</h1>";
echo "<p>Hier haben sie eine Übersicht über die vorhandenen Einheiten.</p>";

$einheiten = new Einheiten();
$alleElemente = $einheiten -> alleElemente();

$fehler = new Validieren();

if(!empty($_SESSION["erfolg"])){
    echo "<p style='color:green'>".$_SESSION["erfolg"]."</p>";
    unset($_SESSION["erfolg"]);
}
if(!empty($_SESSION["fehlermeldung"])){
    echo "<p style='color:red'>".$_SESSION["fehlermeldung"]."</p>";
    unset($_SESSION["fehlermeldung"]);
}


// Artikel bearbeiten
if(!empty($_POST["e_bearbeiten"])){
    $_SESSION["e_bearbeiten"]=$_POST["e_bearbeiten"];
    header("location: einheit_aendern.php");
    exit();
}

// einheit hinzufügen
if(!empty($_POST["hinzu"])){
    header("location: einheit_aendern.php");
    exit();
}

// löschen 
if(!empty($_POST["e_loeschen"]) || !empty($_POST["e_loeschen_bestaetigung"])){
    if(!empty($_POST["e_loeschen"])){
        $_SESSION["e_loeschen"]=($_POST["e_loeschen"]); //übergabe der id von $Post an $session
    }
    
    // Abfrage ob es zu dieser Einheit noch eine Verknüpfung zu einer Speise gibt
    $einheit = new Einheit($_SESSION["e_loeschen"]);
    
    if(!$einheit -> existiertVerbindung() ){//abfragen ob es noch eine Verknüpfung zu einer Speise gibt
        $fehler-> fehlerdazu("Es existiert noch eine Verknüpfung mit dieser Einheit zu einer Speise! <br>
            Bitte löschen sie vorher die zugehörige/n Speisen!");
            unset($_POST["e_loeschen"]);
    } else {
        if(empty($_POST["e_loeschen_bestaetigung"]) ){
            echo "<p style='color:red'>??? Wollen sie die ausgewählte Einheit wirklich endgültig löschen: ???<br> <strong>{$einheit->getSpalte("name")}</strong></p>";
            echo "<form method='post'>";
                    echo '<button class="sub_buttons" type="submit" name="e_loeschen_bestaetigung" value="1">JA</button>';
                    echo '<button class="sub_buttons" type="submit" name="e_loeschen_bestaetigung" value="0">NEIN</button>';
            echo "</form>";
        } else {
            if($_POST["e_loeschen_bestaetigung"] == 1 ){
                $erfolg= "!!! Einheit erfolgreich gelöscht !!!";
                $einheit -> datensatzLoeschen();
                $alleElemente = $einheiten -> alleElemente(); //Daten Aktuallisieren
                unset($_SESSION["e_loeschen"]);
                unset($_POST["e_loeschen_bestaetigung"]);
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
if(empty($_POST["e_loeschen"]) && empty($_POST["e_loeschen_bestaetigung"])){
  
    echo "<form method='post'>";
        echo '<button class="sub_buttons" type="submit" name="hinzu" value="1">Einheit hinzufügen</button>';
        if(!$alleElemente){//abfragen Einheiten existieren
            $fehler-> fehlerDazu("Keine Einheit zum anzeigen vorhanden!");
        } else {
                echo "<table border='1'>";
                    echo "<thead>";
                        echo "<th> bearbeiten </th> ";   
                        echo "<th> löschen </th> ";
                        echo "<th> Einheit ausgeschrieben</th> ";
                        echo "<th> Einheit Kürzel </th> ";
                    echo "<thead>";
                    echo "<tbody>"; 
                        foreach ($alleElemente as $einheit){
                            echo "<tr>";
                                echo "<td align='center'>" . 
                                    '<button class="mini_buttons" type="submit" name="e_bearbeiten" value="'.$einheit->getSpalte("einheit_id").'">b</button>' 
                                    . "</td>";
                                echo "<td align='center'>" . 
                                    '<button class="mini_buttons" type="submit" name="e_loeschen" value="'.$einheit->getSpalte("einheit_id").'">l</button>' 
                                    . "</td>";
                                echo "<td align='center'>" . $einheit->getSpalte("name"). "</td>";
                                echo "<td align='center'>" . $einheit->getSpalte("kuerzel"). "</td>";
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