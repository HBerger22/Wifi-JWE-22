
<?php

use WIFI\SK\Model\BzEinheit;
use WIFI\SK\Model\Einheiten;
use WIFI\SK\Model\Row\Speise;
use WIFI\SK\Model\Row\Getraenk;
use WIFI\SK\Validieren;

use function WIFI\SK\komma_statt_punkt;

include "setup.php";
include "funktionen.php";

include "kopf.php";

echo "<h1>Speisen - Menge/Einheit/Preis</h1>";
echo "<p>Hier haben sie eine Übersicht über die vorhandenen Menge(n)/Einheit(en)/Preis(e)</p>";

// neues Objekt mit allen kategorien anlegen
    if($_SESSION["objekt"]=="Speise"){
        $speise = new Speise($_SESSION["s_id_mep"]);
    } else {
        $speise = new Getraenk($_SESSION["s_id_mep"]);
    }

// $speise = new Speise($_SESSION["s_id_mep"]);
// $alleElemente = $kategorien-> alleElemente();   

$fehler = new Validieren;


$bzMep=new BzEinheit($_SESSION["s_id_mep"],$_SESSION["objekt"]);
$alleMep= $bzMep->alleMepEinerSpeise();

// $einheiten= new Einheiten();
// $alleEinheiten= $einheiten->alleElemente();

if(!empty($_SESSION["erfolg"])){
    echo "<p style='color:green'>".$_SESSION["erfolg"]."</p>";
    unset($_SESSION["erfolg"]);
}
if(!empty($_SESSION["fehlermeldung"])){
    echo "<p style='color:red'>".$_SESSION["fehlermeldung"]."</p>";
    unset($_SESSION["fehlermeldung"]);
}

unset($_SESSION["s_mep_bearbeiten"]);

// echo'S_Session:';
// echo"<pre>"; //print_r Inhalt aus einem Array darstellen (nur zum debuggen)
// print_r($_SESSION);
// echo "</pre>";
//  echo'alleMep: ';
//  echo"<pre>"; //print_r Inhalt aus einem Array darstellen (nur zum debuggen)
//  print_r($alleMep);
//  echo "</pre>";

// MEP bearbeiten
if(!empty($_POST["mep_bearbeiten"])){
    $_SESSION["mep_bearbeiten"]=$_POST["mep_bearbeiten"];
    header("location: speise_mep_aendern.php");
    exit();
}


// MEP hinzufügen
if(!empty($_POST["hinzu"])){
    header("location: speise_mep_aendern.php");
    exit();
}

if($bzMep->getBzIdOhneMep()){
    $_SESSION["mep_bearbeiten"]=$bzMep->getBzIdOhneMep();
}

// endgültig löschen //!!!!! Überprüfung ob noch eine Verknüpfung zu speisen - Getränke besteht
if(!empty($_POST["mep_loeschen"]) || !empty($_POST["mep_loeschen_bestaetigung"])){
    if(!empty($_POST["mep_loeschen"])){
        $_SESSION["mep_loeschen"]=$_POST["mep_loeschen"]; //übergabe der id von $Post an $session
    }

    // Abfrage ob es zu dieser Einheit noch eine Verknüpfung zu einer Speise gibt
    // $kat = new Kat($_SESSION["mep_loeschen"]);
    
    // if(!$kat -> existiertVerbindung()){//abfragen ob es noch eine Verknüpfung zu einer Speise gibt
    //     $fehler -> fehlerDazu("Es existiert noch eine Verknüpfung mit dieser Kategorie zu einer Speise! <br>
    //         Bitte löschen sie vorher die zugehörige/n Speisen!");
    //         unset($_POST["mep_loeschen"]);
    // } else {
        
        $mep_loeschen=$bzMep->getEinzelnenMep($_SESSION["mep_loeschen"]);
        if(empty($_POST["mep_loeschen_bestaetigung"]) ){
            echo "<p style='color:red'>??? Wollen sie die ausgewählte MEP wirklich endgültig löschen: ???<br> <strong>{$mep_loeschen["menge"]} {$mep_loeschen["ename"]} Preis: {$mep_loeschen["preis"]}</strong></p>";
            echo "<form method='post'>";
                    echo '<button class="sub_buttons" type="submit" name="mep_loeschen_bestaetigung" value="1">JA</button>';
                    echo '<button class="sub_buttons" type="submit" name="mep_loeschen_bestaetigung" value="0">NEIN</button>';
            echo "</form>";
        } else {
            if($_POST["mep_loeschen_bestaetigung"] == 1 ){
                $erfolg= "!!! MEP erfolgreich gelöscht !!!";
                $bzMep -> datensatzLoeschen($_SESSION["mep_loeschen"]);
                // Speise auf inaktiv setzen sollte es keine weiteren MEP geben.
                if(!$bzMep->alleMepEinerSpeise()){
                    $speise->akDeak(0);
                }
                $alleMep= $bzMep->alleMepEinerSpeise();   //daten aktuallisieren
                unset($_SESSION["mep_loeschen"]);
                unset($_POST["mep_loeschen_bestaetigung"]);
            }
        }
    // }
}

// einzelne Kategorieren Aktivieren/deaktivieren mithilfe der versteckten Checkboxen cbid in der die ID gespeichert ist und session[num_rows].
if(!empty($_POST["aktivieren"])){
    foreach ($alleMep as $mep){
        if (!empty($_POST["cb".$mep["bz_sk_id"]])){
            $bzMep -> akDeak($mep["bz_sk_id"],1);
        } else {
            $bzMep -> akDeak($mep["bz_sk_id"],0);
        }        
    }
    $alleMep = $bzMep-> alleMepEinerSpeise();     //Daten Aktualisieren  
}


if(!empty($erfolg)){
    echo "<p style='color:green'>".$erfolg."</p>";
}

if($fehler->fehlerAufgetreten()){
    echo "<p style='color:red'>".$fehler -> fehlerAusgabeHtml() ."</p>";
    unset($fehler);
}

// vorhandenen MEP auflisten 
if(empty($_POST["mep_loeschen"]) && empty($_POST["mep_loeschen_bestaetigung"])){

        echo "<form method='post'>";
            echo '<button class="sub_buttons" type="submit" name="hinzu" value="1">Menge/Einheit/Preis hinzufügen</button>';
            if(!$alleMep){//abfragen MEP existieren
                $fehler -> fehlerDazu("Keine Menge/Einheit/Preis zum anzeigen vorhanden!");
            } else {
                //setzen der gesamtanzahl an zeilen damit beim aktiv/deaktiv. alle Menupunkte durchlaufen werden.
                    echo '<button class="sub_buttons" type="submit" name="aktivieren" value="1">Aktivieren/deaktivieren</button>';

                    echo "<table border='1' align='center'>";
                        echo "<thead>";
                            echo "<th> Aktiv </th> "; 
                            echo "<th> bearbeiten </th> ";   
                            echo "<th> löschen </th> ";
                            echo "<th> Menge </th> ";
                            echo "<th> Einheit </th> ";
                            echo "<th> Preis </th> ";
                        echo "<thead>";
                        echo "<tbody>"; 
                            foreach ($alleMep as $mep){
                                if($mep["aktiv"]=="1"){
                                    $checkb="<input type='checkbox' name='cb{$mep["bz_sk_id"]}' value='{$mep["bz_sk_id"]}' checked>";
                                    $bgcolor="green";
                                } else {
                                    $checkb="<input type='checkbox' name='cb{$mep["bz_sk_id"]}' value='{$mep["bz_sk_id"]}'>";
                                    $bgcolor="red";
                                }
                                echo "<tr>";
                                    echo "<td align='center' style='background-color: {$bgcolor}'>" . $checkb. "</td>";
                                    echo "<td align='center'>" . 
                                        '<button class="mini_buttons" type="submit" name="mep_bearbeiten" value="'.$mep["bz_sk_id"].'">b</button>' 
                                        . "</td>";
                                    echo "<td align='center'>" . 
                                        '<button class="mini_buttons" type="submit" name="mep_loeschen" value="'.$mep["bz_sk_id"].'">l</button>' 
                                        . "</td>";
                                    echo "<td align='center'>" . $mep["menge"]. "</td>";
                                    echo "<td align='center'>" . $mep["ename"]. "</td>";
                                    echo "<td align='center'>" . komma_statt_punkt($mep["preis"]). "</td>";
                                echo "</tr> ";
                            }
                        echo "</tbody>";
                    echo "</table border='1'>";
            }
        echo "</form>";
    // }
}

if(!empty($fehler) && $fehler->fehlerAufgetreten()){
    echo "<p style='color:red'>".$fehler -> fehlerAusgabeHtml() ."</p>";
    unset($fehler);
}
// if(!empty($fehlermeldung)){
//     echo "<p style='color:red'>".$fehlermeldung."</p>";
// }
  

// $result->close();
// $con->close();







include "fuss.php";