
<?php
include "funktionen.php";

include "kopf.php";

echo "<h1>Kategorien</h1>";
echo "<p>Hier haben sie eine Übersicht über die vorhandenen Kategorien.</p>";

   
if(!empty($_SESSION["erfolg"])){
    echo "<p style='color:green'>".$_SESSION["erfolg"]."</p>";
    unset($_SESSION["erfolg"]);
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

if(!empty($_POST["k_bearbeiten"])){
    $_SESSION["k_bearbeiten"]=$_POST["k_bearbeiten"];
    header("location: kategorie_aendern.php");
    exit();
}

// Kategorie hinzufügen
if(!empty($_POST["hinzu"])){
    header("location: kategorie_hinzu.php");
    exit();
}

// endgültig löschen //!!!!! Überprüfung ob noch eine Verknüpfung zu speisen - Getränke besteht
if(!empty($_POST["k_loeschen"]) || !empty($_POST["k_loeschen_bestaetigung"])){
    if(!empty($_POST["k_loeschen"])){
        $_SESSION["k_loeschen"]=$_POST["k_loeschen"]; //übergabe der id von $Post an $session
        escape($_SESSION["k_loeschen"]);
    }
    $sql="SELECT * from kategorie where `kategorie_id`= {$_SESSION["k_loeschen"]}";
    $result=$con->query($sql);
    $daten_satz=$result->fetch_assoc();

    if(empty($_POST["k_loeschen_bestaetigung"]) ){
        echo "<p style='color:red'>??? Wollen sie die ausgewählte Kategorie wirklich endgültig löschen: ???<br> <strong>{$daten_satz["name"]}</strong></p>";
        echo "<form method='post'>";
                echo '<button class="sub_buttons" type="submit" name="k_loeschen_bestaetigung" value="1">JA</button>';
                echo '<button class="sub_buttons" type="submit" name="k_loeschen_bestaetigung" value="0">NEIN</button>';
        echo "</form>";
    } else {
        if($_POST["k_loeschen_bestaetigung"] == 1 ){
            $erfolg= "!!! Kategorie erfolgreich gelöscht !!!";
            $sql="DELETE from kategorie where `kategorie_id`= '{$_SESSION["k_loeschen"]}'";
            $con->query($sql);
            unset($_SESSION["k_loeschen"]);
            unset($_POST["k_loeschen_bestaetigung"]);
        }
    }
}

// einzelne Kategorieren Aktivieren/deaktivieren mithilfe der versteckten Checkboxen cbid in der die ID gespeichert ist und session[num_rows].
if(!empty($_POST["aktivieren"])){
    for ($i=1; $i<=$_SESSION["num_rows"]; $i++){
        $index="cbid".$i;
        if(!empty($_POST["cb{$i}"])){ // checkbox aktiviert?
            $sql="UPDATE kategorie set aktiv = 1 where kategorie_id={$_POST['cbid'.$i]}";
        } else {
            $sql="UPDATE Kategorie set aktiv = 0 where kategorie_id={$_POST['cbid'.$i]}";
        }
        $con->query($sql); 
        $erfolg= "<p style='color:green'>Kategorie erfolgreich aktiviert/deaktiviert!</p>";
    }
    // unset($_SESSION["num_rows"]);
}

if(!empty($erfolg)){
    echo "<p style='color:green'>".$erfolg."</p>";
}

// vorhandenen Kategorien auflisten 
if(empty($_POST["s_loeschen"]) && empty($_POST["s_loeschen_bestaetigung"])){
    $sql = "SELECT * from kategorie order by aktiv desc, name asc;";

    if($result=$con->query($sql)){ 
        echo "<form method='post'>";
            echo '<button class="sub_buttons" type="submit" name="hinzu" value="1">Kategorie hinzufügen</button>';
            if($result->num_rows == 0){//abfragen ob der Benutzer existiert
                $fehlermeldung="Keine Kategorie zum anzeigen vorhanden!";
            } else {
                //setzen der gesamtanzahl an zeilen damit beim aktiv/deaktiv. alle Menupunkte durchlaufen werden.
                $_SESSION["num_rows"]=$result->num_rows; 
                    echo '<button class="sub_buttons" type="submit" name="aktivieren" value="1">Aktivieren/deaktivieren</button>';

                    echo "<table border='1'>";
                        echo "<thead>";
                            echo "<th> Aktiv </th> "; 
                            echo "<th> bearbeiten </th> ";   
                            echo "<th> löschen </th> ";
                            echo "<th style='display:none'> ID </th> ";
                            echo "<th> Name </th> ";
                            echo "<th> Beschreibung </th> ";
                        echo "<thead>";
                        echo "<tbody>"; 
                            $i=1;
                            while ($daten_satz=$result->fetch_assoc()){
                            
                                if($daten_satz["aktiv"]=="1"){
                                    $checkb="<input type='checkbox' name='cb{$i}' value='{$daten_satz["kategorie_id"]}' checked>";
                                    $bgcolor="green";
                                } else {
                                    $checkb="<input type='checkbox' name='cb{$i}' value='{$daten_satz["kategorie_id"]}'>";
                                    $bgcolor="red";
                                }
                                $checkb_id="<input type='checkbox' name='cbid{$i}' value='{$daten_satz["kategorie_id"]}' checked>";

                                echo "<tr>";
                                    echo "<td align='center' style='background-color: {$bgcolor}'>" . $checkb. "</td>";
                                    echo "<td align='center'>" . 
                                        '<button class="mini_buttons" type="submit" name="k_bearbeiten" value="'.$daten_satz["kategorie_id"].'">b</button>' 
                                        . "</td>";
                                    echo "<td align='center'>" . 
                                        '<button class="mini_buttons" type="submit" name="k_loeschen" value="'.$daten_satz["kategorie_id"].'">l</button>' 
                                        . "</td>";

                                    // versteckte Checkbox cbid zum aktivieren/deaktivieren.
                                    echo "<td align='center' style='display:none'>" . $checkb_id . "</td>";
                                    echo "<td align='center'>" . $daten_satz["name"]. "</td>";
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