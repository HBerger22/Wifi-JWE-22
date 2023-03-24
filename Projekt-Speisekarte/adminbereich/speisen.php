
<?php
include "funktionen.php";

include "kopf.php";

echo "<h1>Speisenübersicht</h1>";


    
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

if(!empty($_POST["s_bearbeiten"])){
    $_SESSION["s_bearbeiten"]=$_POST["s_bearbeiten"];
    header("location: speise_aendern.php");
    exit();
}

// speisen hinzufügen
if(!empty($_POST["hinzu"])){
    header("location: speise_hinzu.php");
    exit();
}

// Speise endgültig löschen
if(!empty($_POST["s_loeschen"]) || !empty($_POST["s_loeschen_bestaetigung"])){
    if(!empty($_POST["s_loeschen"]))
        $_SESSION["s_loeschen"]=$_POST["s_loeschen"]; //übergabe der id von $Post an $session
    $sql="SELECT * from speisen where `id`= {$_SESSION["s_loeschen"]}";
    $result=$con->query($sql);
    $daten_satz=$result->fetch_assoc();

    if(empty($_POST["s_loeschen_bestaetigung"]) ){
        echo "<p style='color:red'>??? Wollen sie die ausgewählte Speise wirklich endgültig löschen: ???<br> <strong>{$daten_satz["name"]}</strong></p>";
        echo "<form method='post'>";
                echo '<button class="sub_buttons" type="submit" name="s_loeschen_bestaetigung" value="1">JA</button>';
                echo '<button class="sub_buttons" type="submit" name="s_loeschen_bestaetigung" value="0">NEIN</button>';
        echo "</form>";
    } else {
        if($_POST["s_loeschen_bestaetigung"] == 1 ){
            $erfolg= "!!! Speise erfolgreich gelöscht !!!";
            $sql="DELETE from speisen where `id`= '{$_SESSION["s_loeschen"]}'";
            $con->query($sql);
            unset($_SESSION["s_loeschen"]);
            unset($_POST["s_loeschen_bestaetigung"]);
        }
    }
}

// einzelne Artiekl Aktivieren/deaktivieren mithilfe der versteckten Checkboxen cbid in der die ID gespeichert ist und session[num_rows].
if(!empty($_POST["aktivieren"])){
    for ($i=1; $i<=$_SESSION["num_rows"]; $i++){
        $index="cbid".$i;
        if(!empty($_POST["cb{$i}"])){ // checkbox aktiviert?
            $sql="UPDATE speisen set aktiv = 1 where id={$_POST['cbid'.$i]}";
        } else {
            $sql="UPDATE speisen set aktiv = 0 where id={$_POST['cbid'.$i]}";
        }
        $con->query($sql); 
        $erfolg= "<p style='color:green'>Speisen erfolgreich aktiviert/deaktiviert!</p>";
    }
    // unset($_SESSION["num_rows"]);
}

if(!empty($erfolg)){
    echo "<p style='color:green'>".$erfolg."</p>";
}



// vorhandenen speisen auflisten 
if(empty($_POST["s_loeschen"]) && empty($_POST["s_loeschen_bestaetigung"])){
    $sql = "SELECT * from speisen order by aktiv desc, name asc;";

    if($result=$con->query($sql)){ 
        if($result->num_rows == 0){//abfragen ob der Benutzer existiert
            $fehlermeldung="Keine Speisen zum anzeigen vorhanden!";
        } else {
            //setzen der gesamtanzahl an zeilen damit beim aktiv/deaktiv. alle Menupunkte durchlaufen werden.
            $_SESSION["num_rows"]=$result->num_rows; 
            echo "<form method='post'>";
                echo '<button class="sub_buttons" type="submit" name="aktivieren" value="1">Aktivieren/deaktivieren</button>';
                echo '<button class="sub_buttons" type="submit" name="hinzu" value="1">Speise hinzufügen</button>';

                echo "<table border='1'>";
                    echo "<thead>";
                        echo "<th> Aktiv </th> "; 
                        echo "<th> bearbeiten </th> ";   
                        echo "<th> löschen </th> ";
                        echo "<th style='display:none'> ID </th> ";
                        echo "<th> Name </th> ";
                        echo "<th> Beschreibung </th> ";
                        echo "<th> Preis </th> ";
                    echo "<thead>";
                    echo "<tbody>"; 
                        $i=1;
                        while ($daten_satz=$result->fetch_assoc()){
                        
                            if($daten_satz["aktiv"]=="1"){
                                $checkb="<input type='checkbox' name='cb{$i}' value='{$daten_satz["id"]}' checked>";
                                $bgcolor="green";
                            } else {
                                $checkb="<input type='checkbox' name='cb{$i}' value='{$daten_satz["id"]}'>";
                                $bgcolor="red";
                            }
                            $checkb_id="<input type='checkbox' name='cbid{$i}' value='{$daten_satz["id"]}' checked>";

                            echo "<tr>";
                                echo "<td align='center' style='background-color: {$bgcolor}'>" . $checkb. "</td>";
                                echo "<td align='center'>" . 
                                    '<button class="mini_buttons" type="submit" name="s_bearbeiten" value="'.$daten_satz["id"].'">b</button>' 
                                    . "</td>";
                                echo "<td align='center'>" . 
                                    '<button class="mini_buttons" type="submit" name="s_loeschen" value="'.$daten_satz["id"].'">l</button>' 
                                    . "</td>";

                                // versteckte Checkbox cbid zum aktivieren/deaktivieren.
                                echo "<td align='center' style='display:none'>" . $checkb_id . "</td>";
                                echo "<td align='center'>" . $daten_satz["name"]. "</td>";
                                echo "<td align='center'>" . $daten_satz["beschreibung"]. "</td>";
                                echo "<td align='center'>" .  zwei_kommastellen($daten_satz["preis"] , 1 ). "</td>";
                            echo "</tr> ";
                            $i++;
                        }
                    echo "</tbody>";
                echo "</table border='1'>";
            echo "</form>";
        }
    }
}

if(!empty($fehlermeldung)){
    echo "<p style='color:red'>".$fehlermeldung."</p>";
}
  

$result->close();
$con->close();







include "fuss.php";