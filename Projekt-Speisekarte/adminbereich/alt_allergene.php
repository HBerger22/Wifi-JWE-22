
<?php
include "funktionen.php";

include "kopf.php";

echo "<h1>Allergene</h1>";
echo "<p>Hier haben sie eine Übersicht über die vorhandenen Allergene.</p>";

   
if(!empty($_SESSION["erfolg"])){
    echo "<p style='color:green'>".$_SESSION["erfolg"]."</p>";
    unset($_SESSION["erfolg"]);
}
// if(!empty($_SESSION["fehlermeldung"])){
//     echo "<p style='color:red'>".$_SESSION["fehlermeldung"]."</p>";
//     unset($_SESSION["fehlermeldung"]);
// }

// Allergen bearbeiten

if(!empty($_POST["a_bearbeiten"])){
    $_SESSION["a_bearbeiten"]=$_POST["a_bearbeiten"];
    header("location: allergene_aendern.php");
    exit();
}

// Allergen hinzufügen
if(!empty($_POST["hinzu"])){
    header("location: allergene_hinzu.php");
    exit();
}

// endgültig löschen //!!!!! Überprüfung ob noch eine Verknüpfung zu speisen - Getränke besteht
if(!empty($_POST["a_loeschen"]) || !empty($_POST["a_loeschen_bestaetigung"])){
    if(!empty($_POST["a_loeschen"])){
        $_SESSION["a_loeschen"]=escape($_POST["a_loeschen"]); //übergabe der id von $Post an $session
    }

// Abfrage ob es zu dieser Einheit noch eine Verknüpfung zu einer Speise gibt
$sql="SELECT * FROM `bz_speise_allergene` where allergene_id='{$_SESSION["a_loeschen"]}'";
$result=$con->query($sql);

if($result->num_rows != 0){//abfragen ob es noch eine Verknüpfung zu einer Speise gibt
    $fehlermeldung="Es existiert noch eine Verknüpfung mit dieser Allergen zu einer Speise! <br>
        Bitte löschen sie vorher die zugehörige/n Speisen!";
        unset($_POST["a_loeschen"]);
} else {


        $sql="SELECT * from allergene where `allergene_id`= {$_SESSION["a_loeschen"]}";
        $result=$con->query($sql);
        $daten_satz=$result->fetch_assoc();

        if(empty($_POST["a_loeschen_bestaetigung"]) ){
            echo "<p style='color:red'>??? Wollen sie das ausgewählte Allergen wirklich endgültig löschen: ???<br> <strong>{$daten_satz["name"]}</strong></p>";
            echo "<form method='post'>";
                    echo '<button class="sub_buttons" type="submit" name="a_loeschen_bestaetigung" value="1">JA</button>';
                    echo '<button class="sub_buttons" type="submit" name="a_loeschen_bestaetigung" value="0">NEIN</button>';
            echo "</form>";
        } else {
            if($_POST["a_loeschen_bestaetigung"] == 1 ){
                $sql="DELETE from allergen where `allergen_id`= '{$_SESSION["a_loeschen"]}'";
                $con->query($sql);
                $erfolg= "!!! Allergen erfolgreich gelöscht !!!";
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
//             $sql="UPDATE kategorie set aktiv = 1 where kategorie_id={$_POST['cbid'.$i]}";
//         } else {
//             $sql="UPDATE Kategorie set aktiv = 0 where kategorie_id={$_POST['cbid'.$i]}";
//         }
//         $con->query($sql); 
//         $erfolg= "<p style='color:green'>Kategorie erfolgreich aktiviert/deaktiviert!</p>";
//     }
//     // unset($_SESSION["num_rows"]);
// }

if(!empty($erfolg)){
    echo "<p style='color:green'>".$erfolg."</p>";
}
if(!empty($fehlermeldung)){
    echo "<p style='color:red'>".$fehlermeldung."</p>";
    unset($fehlermeldung);
}

// vorhandenen Kategorien auflisten 
if(empty($_POST["a_loeschen"]) && empty($_POST["a_loeschen_bestaetigung"])){
    $sql = "SELECT * from allergene order by  klasse asc;";

    if($result=$con->query($sql)){ 
        echo "<form method='post'>";
            echo '<button class="sub_buttons" type="submit" name="hinzu" value="1">Allergene hinzufügen</button>';
            if($result->num_rows == 0){//abfragen ob der Benutzer existiert
                $fehlermeldung="Keine Allergene zum anzeigen vorhanden!";
            } else {
                //setzen der gesamtanzahl an zeilen damit beim aktiv/deaktiv. alle Menupunkte durchlaufen werden.
                $_SESSION["num_rows"]=$result->num_rows; 
                    // echo '<button class="sub_buttons" type="submit" name="aktivieren" value="1">Aktivieren/deaktivieren</button>';

                    echo "<table border='1'>";
                        echo "<thead>";
                            echo "<th> bearbeiten </th> ";   
                            echo "<th> löschen </th> ";
                            echo "<th style='display:none'> ID </th> ";
                            echo "<th> Klasse </th> ";
                            echo "<th> Name </th> ";
                            echo "<th> Beschreibung </th> ";
                        echo "<thead>";
                        echo "<tbody>"; 
                            $i=1;
                            while ($daten_satz=$result->fetch_assoc()){
                            
                                // if($daten_satz["aktiv"]=="1"){
                                //     $checkb="<input type='checkbox' name='cb{$i}' value='{$daten_satz["kategorie_id"]}' checked>";
                                //     $bgcolor="green";
                                // } else {
                                //     $checkb="<input type='checkbox' name='cb{$i}' value='{$daten_satz["kategorie_id"]}'>";
                                //     $bgcolor="red";
                                // }
                                $checkb_id="<input type='checkbox' name='cbid{$i}' value='{$daten_satz["allergene_id"]}' checked>";

                                echo "<tr>";
                                    // echo "<td align='center' style='background-color: {$bgcolor}'>" . $checkb. "</td>";
                                    echo "<td align='center'>" . 
                                        '<button class="mini_buttons" type="submit" name="a_bearbeiten" value="'.$daten_satz["allergene_id"].'">b</button>' 
                                        . "</td>";
                                    echo "<td align='center'>" . 
                                        '<button class="mini_buttons" type="submit" name="a_loeschen" value="'.$daten_satz["allergene_id"].'">l</button>' 
                                        . "</td>";

                                    // versteckte Checkbox cbid zum aktivieren/deaktivieren.
                                    echo "<td align='center' style='display:none'>" . $checkb_id . "</td>";
                                    echo "<td align='center'>" . $daten_satz["klasse"]. "</td>";
                                    echo "<td align='center'>" . $daten_satz["bezeichnung"]. "</td>";
                                    echo "<td align='center'>" . $daten_satz["beschreibung"]. "</td>";
                                echo "</tr> ";
                                $i++;
                            }
                        echo "</tbody>";
                    echo "</table border='1'>";
            }
        echo "</form>";
    }
}

if(!empty($fehlermeldung)){
    echo "<p style='color:red'>".$fehlermeldung."</p>";
}
  

$result->close();
$con->close();







include "fuss.php";