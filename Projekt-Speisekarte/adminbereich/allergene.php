
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

// echo'S_Session:';
// echo"<pre>"; //print_r Inhalt aus einem Array darstellen (nur zum debuggen)
// print_r($_SESSION);
// echo "</pre>";
// echo'S_post:';
// echo"<pre>"; //print_r Inhalt aus einem Array darstellen (nur zum debuggen)
// print_r($_POST);
// echo "</pre>";

// Artikel bearbeiten

if(!empty($_POST["a_bearbeiten"])){
    $_SESSION["a_bearbeiten"]=$_POST["a_bearbeiten"];
    header("location: allergen_aendern.php");
    exit();
}

// einheit hinzufügen
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
    // $sql="SELECT * FROM `bz_speise_kategorie` where einheit_id='{$_SESSION["e_loeschen"]}'";
    // $result=$con->query($sql);
    
    if(!$allergen -> existiertVerbindung() ){//abfragen ob es noch eine Verknüpfung zu einer Speise gibt
        $fehler-> fehlerdazu("Es existiert noch eine Verknüpfung mit dieser Einheit zu einer Speise! <br>
            Bitte löschen sie vorher die zugehörige/n Speisen!");
            unset($_POST["a_loeschen"]);
    } else {
        // $sql="SELECT * from einheit where `einheit_id`= {$_SESSION["e_loeschen"]}";
        // $result=$con->query($sql);
        // $daten_satz=$result->fetch_assoc();
        
        

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
                // $sql="DELETE from einheit where `einheit_id`= '{$_SESSION["e_loeschen"]}'";
                // $con->query($sql);
                unset($_SESSION["a_loeschen"]);
                unset($_POST["a_loeschen_bestaetigung"]);
            }
        }
    }
}

// einzelne Kategorieren Aktivieren/deaktivieren mithilfe der versteckten Checkboxen cbid in der die ID gespeichert ist und session[num_rows].
// if(!empty($_POST["aktivieren"])){
//     for ($i=1; $i<=$_SESSION["num_rows"]; $i++){
//         $index="cbid".$i;
//         if(!empty($_POST["cb{$i}"])){ // checkbox aktiviert?
//             $sql="UPDATE kategorie set aktiv = 1 where id={$_POST['cbid'.$i]}";
//         } else {
//             $sql="UPDATE Kategorie set aktiv = 0 where id={$_POST['cbid'.$i]}";
//         }
//         $con->query($sql); 
//         $erfolg= "<p style='color:green'>Kategorie erfolgreich aktiviert/deaktiviert!</p>";
//     }
//     // unset($_SESSION["num_rows"]);
// }

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
            // Button zum Aktivieren und Deaktivieren einzelner Elemente
            // echo '<button class="sub_buttons" type="submit" name="aktivieren" value="1">Aktivieren/deaktivieren</button>';
            
                echo "<table border='1'>";
                    echo "<thead>";
                        // echo "<th> Aktiv </th> "; 
                        echo "<th> bearbeiten </th> ";   
                        echo "<th> löschen </th> ";
                        // echo "<th style='display:none'> ID </th> ";
                        echo "<th> Klasse</th> ";
                        echo "<th> Name </th> ";
                        echo "<th> Beschreibung </th> ";
                        // echo "<th> Preis </th> ";
                    echo "<thead>";
                    echo "<tbody>"; 
                        foreach ($alleElemente as $allergen){
                        
                            // if($daten_satz["aktiv"]=="1"){
                            //     $checkb="<input type='checkbox' name='cb{$i}' value='{$daten_satz["id"]}' checked>";
                            //     $bgcolor="green";
                            // } else {
                            //     $checkb="<input type='checkbox' name='cb{$i}' value='{$daten_satz["id"]}'>";
                            //     $bgcolor="red";
                            // }
                            // $checkb_id="<input type='checkbox' name='cbid{$i}' value='{$daten_satz["id"]}' checked>";

                            echo "<tr>";
                                // echo "<td align='center' style='background-color: {$bgcolor}'>" . $checkb. "</td>";
                                echo "<td align='center'>" . 
                                    '<button class="mini_buttons" type="submit" name="a_bearbeiten" value="'.$allergen->getSpalte("allergen_id").'">b</button>' 
                                    . "</td>";
                                echo "<td align='center'>" . 
                                    '<button class="mini_buttons" type="submit" name="a_loeschen" value="'.$allergen->getSpalte("allergen_id").'">l</button>' 
                                    . "</td>";

                                // versteckte Checkbox cbid zum aktivieren/deaktivieren.
                                // echo "<td align='center' style='display:none'>" . $checkb_id . "</td>";
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
// if(!empty($fehlermeldung)){
//     echo "<p style='color:red'>".$fehlermeldung."</p>";
// }
  

// $result->close();
// $con->close();







include "fuss.php";