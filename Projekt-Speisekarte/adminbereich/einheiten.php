
<?php
include "funktionen.php";

include "kopf.php";

echo "<h1>Einheiten</h1>";
echo "<p>Hier haben sie eine Übersicht über die vorhandenen Einheiten.</p>";


   
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

if(!empty($_POST["e_bearbeiten"])){
    $_SESSION["e_bearbeiten"]=$_POST["e_bearbeiten"];
    header("location: einheiten_aendern.php");
    exit();
}

// speisen hinzufügen
if(!empty($_POST["hinzu"])){
    header("location: einheiten_hinzu.php");
    exit();
}

// löschen 
if(!empty($_POST["e_loeschen"]) || !empty($_POST["e_loeschen_bestaetigung"])){
    if(!empty($_POST["e_loeschen"])){
        $_SESSION["e_loeschen"]=escape($_POST["e_loeschen"]); //übergabe der id von $Post an $session
        // escape($_SESSION["e_loeschen"]);
    }
    
    // Abfrage ob es zu dieser Einheit noch eine Verknüpfung zu einer Speise gibt
    $sql="SELECT * FROM `bz_speise_kategorie` where einheit_id='{$_SESSION["e_loeschen"]}'";
    $result=$con->query($sql);
    
    if($result->num_rows != 0){//abfragen ob es noch eine Verknüpfung zu einer Speise gibt
        $fehlermeldung="Es existiert noch eine Verknüpfung mit dieser Einheit zu einer Speise! <br>
            Bitte löschen sie vorher die zugehörige/n Speisen!";
            unset($_POST["e_loeschen"]);
    } else {
        $sql="SELECT * from einheit where `einheit_id`= {$_SESSION["e_loeschen"]}";
        $result=$con->query($sql);
        $daten_satz=$result->fetch_assoc();
        
        

            if(empty($_POST["e_loeschen_bestaetigung"]) ){
                echo "<p style='color:red'>??? Wollen sie die ausgewählte Einheit wirklich endgültig löschen: ???<br> <strong>{$daten_satz["name"]}</strong></p>";
                echo "<form method='post'>";
                        echo '<button class="sub_buttons" type="submit" name="e_loeschen_bestaetigung" value="1">JA</button>';
                        echo '<button class="sub_buttons" type="submit" name="e_loeschen_bestaetigung" value="0">NEIN</button>';
                echo "</form>";
            } else {
                if($_POST["e_loeschen_bestaetigung"] == 1 ){
                    $erfolg= "!!! Einheit erfolgreich gelöscht !!!";
                    $sql="DELETE from einheit where `einheit_id`= '{$_SESSION["e_loeschen"]}'";
                    $con->query($sql);
                    unset($_SESSION["e_loeschen"]);
                    unset($_POST["e_loeschen_bestaetigung"]);
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
if(!empty($fehlermeldung)){
    echo "<p style='color:red'>".$fehlermeldung."</p>";
    unset($fehlermeldung);
}



// vorhandenen einheit auflisten 
if(empty($_POST["e_loeschen"]) && empty($_POST["e_loeschen_bestaetigung"])){
    $sql = "SELECT * from einheit order by name asc;";

    if($result=$con->query($sql)){ 
        echo "<form method='post'>";
                // echo '<button class="sub_buttons" type="submit" name="aktivieren" value="1">Aktivieren/deaktivieren</button>';
            echo '<button class="sub_buttons" type="submit" name="hinzu" value="1">Einheit hinzufügen</button>';
        if($result->num_rows == 0){//abfragen ob der Benutzer existiert
            $fehlermeldung="Keine Einheit zum anzeigen vorhanden!";
        } else {
            //setzen der gesamtanzahl an zeilen damit beim aktiv/deaktiv. alle Menupunkte durchlaufen werden.
            $_SESSION["num_rows"]=$result->num_rows; 
            
                echo "<table border='1'>";
                    echo "<thead>";
                        // echo "<th> Aktiv </th> "; 
                        echo "<th> bearbeiten </th> ";   
                        echo "<th> löschen </th> ";
                        // echo "<th style='display:none'> ID </th> ";
                        echo "<th> Einheit ausgeschrieben</th> ";
                        echo "<th> Einheit Kürzel </th> ";
                        // echo "<th> Preis </th> ";
                    echo "<thead>";
                    echo "<tbody>"; 
                        $i=1;
                        while ($daten_satz=$result->fetch_assoc()){
                        
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
                                    '<button class="mini_buttons" type="submit" name="e_bearbeiten" value="'.$daten_satz["einheit_id"].'">b</button>' 
                                    . "</td>";
                                echo "<td align='center'>" . 
                                    '<button class="mini_buttons" type="submit" name="e_loeschen" value="'.$daten_satz["einheit_id"].'">l</button>' 
                                    . "</td>";

                                // versteckte Checkbox cbid zum aktivieren/deaktivieren.
                                // echo "<td align='center' style='display:none'>" . $checkb_id . "</td>";
                                echo "<td align='center'>" . $daten_satz["name"]. "</td>";
                                echo "<td align='center'>" . $daten_satz["kuerzel"]. "</td>";
                                // echo "<td align='center'>" .  zwei_kommastellen($daten_satz["preis"] , 1 ). "</td>";
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