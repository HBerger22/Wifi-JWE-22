<?php

use WIFI\SK\Model\Row\Speise;
use WIFI\SK\Model\Speisen;
use WIFI\SK\Validieren;
use WIFI\SK\Model\Allergene;
use WIFI\SK\Model\BzAllergene;
use WIFI\SK\Model\BzKatEinheit;
use WIFI\SK\Model\Getraenke;
use WIFI\SK\Model\Row\Getraenk;

use function WIFI\SK\zwei_kommastellen;

include "setup.php";
include "funktionen.php";
include "kopf.php";
unset($_SESSION["s_bearbeiten"]);
unset($_SESSION["kat_id"]);
unset($_SESSION["s_id_mep"]);
unset ($_SESSION["mep_bearbeiten"]);

echo "<h1>{$_SESSION["objekte"]}übersicht</h1>";
echo "<p>Hier haben sie eine Übersicht über die vorhandenen {$_SESSION["objekte"]}.</p>";
echo "<p>Sie können einzelne/mehrere {$_SESSION["objekte"]} aktivieren und deaktivieren. Damit erscheinen sie nicht mehr im digitalen 
    Menu, sie sind aber jederzeit wieder aktivierbar, sollte es diese/s {$_SESSION["objekt"]} wieder geben.</p>";
if($_SESSION["objekt"]=="speise"){
    $speisen = new Speisen();
    // $objektId="speise_id";
} else {
    $speisen = new Getraenke();
    // $objektId="getraenk_id";
}

$alleSpeisen = $speisen -> alleElemente();

$fehler = new Validieren();

$allergene = new Allergene();
$alleAllergene = $allergene -> alleElemente();

$bzAllergene= new BzAllergene($_SESSION["objekt"]);
$bzKatEinheit = new BzKatEinheit($_SESSION["objekt"]);

if(!empty($_SESSION["erfolg"])){
    echo "<p style='color:green'>".$_SESSION["erfolg"]."</p>";
    unset($_SESSION["erfolg"]);
}

// Artikel bearbeiten
if(!empty($_POST["s_bearbeiten"])){
    $_SESSION["s_bearbeiten"]=$_POST["s_bearbeiten"];
    header("location: speise_aendern.php");
    exit();
}

// speisen hinzufügen
if(!empty($_POST["hinzu"])){
    header("location: speise_aendern.php");
    exit();
}

// Preise bearbeiten
if(!empty($_POST["s_id_mep"])){
    $_SESSION["s_id_mep"]=$_POST["s_id_mep"];
    // $_SESSION["kat_id"]=$_POST["kat_id"];
    header("location: speise_mep.php");
    exit();
}

// Speise endgültig löschen
if(!empty($_POST["s_loeschen"]) || !empty($_POST["s_loeschen_bestaetigung"])){
    if(!empty($_POST["s_loeschen"])){
        $_SESSION["s_loeschen"]=$_POST["s_loeschen"]; //übergabe der id von $Post an $session
    }
    if($_SESSION["objekt"]=="speise"){
        $speise = new Speise($_SESSION["s_loeschen"]);
    } else {
        $speise = new Getraenk($_SESSION["s_loeschen"]);
    }

    if(empty($_POST["s_loeschen_bestaetigung"]) ){
        echo "<p style='color:red'>??? Wollen sie die ausgewählte {$_SESSION["objekt"]} wirklich endgültig löschen: ???<br> <strong>{$speise -> getSpalte("name")}</strong></p>";
        echo "<form method='post'>";
                echo '<button class="sub_buttons" type="submit" name="s_loeschen_bestaetigung" value="1">JA</button>';
                echo '<button class="sub_buttons" type="submit" name="s_loeschen_bestaetigung" value="0">NEIN</button>';
        echo "</form>";
    } else {
        if($_POST["s_loeschen_bestaetigung"] == 1 ){
            $erfolg= "!!! {$_SESSION["objekt"]} erfolgreich gelöscht !!!";
            $speise -> bzLoeschen();
            $speise -> datensatzLoeschen();
            $alleSpeisen = $speisen -> alleElemente();
            unset($_SESSION["s_loeschen"]);
            unset($_POST["s_loeschen_bestaetigung"]);
        }
    }
}

// einzelne Artiekl Aktivieren/deaktivieren mithilfe der versteckten Checkboxen cbid in der die ID gespeichert ist und session[num_rows].
if(!empty($_POST["aktivieren"])){
    foreach ($alleSpeisen as $speise){
        if (!empty($_POST["cb".$speise->getSpalte($objektId)])){
            $erfolgreich=$speise -> akDeakSpeise(1,$_SESSION["objekt"]);
            if(!$erfolgreich){
                $fehler->fehlerDazu( "{$_SESSION["objekt"]}: {$speise->getSpalte("name")} kann nicht aktiviert werden solange es keine aktive MEP (Menge/Einheit/Preis) gibt!");
            }
        } else {
            $speise -> akDeakSpeise(0,$_SESSION["objekt"]);
        }        
    }
    $alleSpeisen = $speisen-> alleElemente();     //Daten Aktualisieren  
}

if(!empty($fehler->fehlerAufgetreten())){
    echo "<p style='color:red'>".$fehler->fehlerAusgabeHtml()."</p>";
}

if(!empty($erfolg)){
    echo "<p style='color:green'>".$erfolg."</p>";
}

// vorhandenen speisen auflisten 
if(!$alleAllergene){
    $fehler->fehlerDazu( "Bitte legen sie mindestens 1 Allergen an!");
}else 
{
    if(empty($_POST["s_loeschen"]) && empty($_POST["s_loeschen_bestaetigung"])){
        echo "<form method='post'>";
            echo '<button autofocus class="sub_buttons" type="submit" name="hinzu" value="1">'.$_SESSION["objekt"].' hinzufügen</button>';
        if(!$alleSpeisen){//abfragen ob mind. 1 Speise existiert
            $fehler->fehlerDazu("Keine {$_SESSION["objekte"]} zum anzeigen vorhanden!");
        } else {
                echo '<button class="sub_buttons" type="submit" name="aktivieren" value="1">Aktivieren/deaktivieren</button>';
                echo "<table border='1'>";
                    echo "<thead>";
                        echo "<th colspan='3'> Bearbeitung </th> "; 
                        echo "<th colspan='2'> {$_SESSION["objekt"]} </th> ";
                        echo "<th colspan='".count($alleAllergene)."'>Allergene</th>";
                        echo "<th colspan='2'> Kategorie  </th> ";
                        echo "<th colspan='5'> MEP = Menge/Einheit/Preis </th> ";
                    echo "</thead>";
                    echo "<thead>";
                        echo "<th> Aktiv </th> "; 
                        echo "<th> bearbeiten </th> ";   
                        echo "<th> löschen </th> ";
                        echo "<th> Name </th> ";
                        echo "<th> Beschreibung </th> ";
                        //Die Allergenklassen abrufen
                        foreach ($alleAllergene as $allergen){
                            echo "<th> {$allergen->getSpalte("klasse")} </th> ";
                        }
                        echo "<th> Aktiv </th> ";
                        echo "<th> Name </th> ";
                        echo "<th> MEP bearbeiten </th> ";
                        echo "<th> Aktiv </th> ";
                        echo "<th> Menge </th> ";
                        echo "<th> Einheit </th> ";
                        echo "<th> Preis </th> ";
                    echo "</thead>";
                    echo "<tbody>"; 
                        foreach ($alleSpeisen as $speise){
                            if($speise->getSpalte ("aktiv")){
                                $checkb="<input type='checkbox' name='cb{$speise->getSpalte($objektId)}' value='{$speise->getSpalte($objektId)}' checked>";
                                $bgcolor="green";
                            } else {
                                $checkb="<input type='checkbox' name='cb{$speise->getSpalte($objektId)}' value='{$speise->getSpalte($objektId)}'>";
                                $bgcolor="red";
                            }
                            echo "<tr>";
                                echo "<td align='center' style='background-color: {$bgcolor}'>" . $checkb. "</td>";
                                echo "<td align='center'>" . 
                                    '<button class="mini_buttons" type="submit" name="s_bearbeiten" value="'.$speise->getSpalte($objektId).'">b</button>' 
                                    . "</td>";
                                echo "<td align='center'>" . 
                                    '<button class="mini_buttons" type="submit" name="s_loeschen" value="'.$speise->getSpalte($objektId).'">l</button>' 
                                    . "</td>";

                                echo "<td align='center'>" . $speise->getSpalte("name"). "</td>";
                                echo "<td align='center'>" . $speise->getSpalte("beschreibung"). "</td>";
                                
                                // Allergene
                                $speiseAllergene=$bzAllergene->alleElemente($speise->getSpalte($objektId));
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
                                        echo "<td align='center'> x </td>"; //die speise hat dieses Allergen
                                    } else {
                                        echo "<td align='center'> - </td>"; //die speise hat dieses Allergen nicht
                                    }
                                }
                                // Kategorie Einheit Preis Typ 
                                $speiseKat=$bzKatEinheit->zugehörigeKat($speise->getSpalte($objektId));
                                $speiseEinheit=$bzKatEinheit->zugehörigeEinhMengePreis($speise->getSpalte($objektId));
                                if ($speiseKat){
                                    echo "<td align='center'>";
                                        if($speiseKat[0]["aktiv"]==1){
                                            echo " <span style='color:green'> &#10004; </span>";
                                        } else {
                                            echo " <span style='color:red'> &#10008; </span>";
                                        }                                        
                                    echo "</td>";
                                    echo "<td align='center'>" . $speiseKat[0]["kname"]. "</td>";
                                }else{
                                    echo "<td align='center'> - </td>";
                                    echo "<td align='center'> - </td>";
                                }
                                echo "<td align='center'>" . 
                                    '<button class="mini_buttons" type="submit" name="s_id_mep" value="'.$speise->getSpalte($objektId).'"> MEP </button>' 
                                    
                                    . "</td>";

                                if ($speiseEinheit){
                                        //Aktiv (notwendig falls mehrere einheiten Mengen vorhanden sind)
                                        
                                        echo "<td align='center'>";
                                            for($i=0;$i<count($speiseEinheit);$i++){
                                                if($speiseEinheit[$i]["aktiv"]==1){
                                                    echo " <span style='color:green'> &#10004; </span>";
                                                } else {
                                                    echo " <span style='color:red'> &#10008; </span>";
                                                }                                        
                                                echo "<br>";
                                            } 
                                        echo "</td>";

                                        //Menge (notwendig falls mehrere einheiten Mengen vorhanden sind)
                                        echo "<td align='center'>";
                                        for($i=0;$i<count($speiseEinheit);$i++){
                                            echo $speiseEinheit[$i]["menge"]."<br>";
                                        } 
                                        echo "</td>";

                                        // Einheit
                                        echo "<td align='center'>";
                                        for($i=0;$i<count($speiseEinheit);$i++){
                                            echo $speiseEinheit[$i]["ename"]."<br>";
                                        } 
                                        echo "</td>";

                                        // Preis
                                        echo "<td align='center'>";
                                        for($i=0;$i<count($speiseEinheit);$i++){
                                            echo zwei_kommastellen($speiseEinheit[$i]["preis"])."<br>";
                                        } 
                                        echo "</td>";
                                } else {   
                                    echo "<td align='center'> - </td>";
                                    echo "<td align='center'> - </td>";
                                    echo "<td align='center'> - </td>";
                                    echo "<td align='center'> - </td>";
                                }
                            echo "</tr> ";
                        }
                    echo "</tbody>";
                echo "</table border='1'>";
            
        }
        echo "</form>";
    }
}

if(!empty($fehler->fehlerAufgetreten())){
    echo "<p style='color:red'>".$fehler->fehlerAusgabeHtml()."</p>";
}
echo "<br><br><br><br><br>"; 
include "fuss.php";