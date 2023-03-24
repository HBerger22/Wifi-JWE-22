<?php
include "funktionen.php";

include "kopf.php";

echo "<h1>Speise bearbeiten</h1>";

// echo'S_Session:';
// echo"<pre>"; //print_r Inhalt aus einem Array darstellen (nur zum debuggen)
// print_r($_SESSION);
// echo "</pre>";
// echo'S_post:';
// echo"<pre>"; //print_r Inhalt aus einem Array darstellen (nur zum debuggen)
// print_r($_POST);
// echo "</pre>";

if(!empty($_SESSION["s_bearbeiten"])){
    $sql="SELECT * from speisen where `id`= {$_SESSION["s_bearbeiten"]};";
    if($result=$con->query($sql)){ 
        if($result->num_rows == 0){//abfragen ob die Speise existiert
            $fehlermeldung="Diese Speise existiert nicht!";
            unset($_SESSION["s_bearbeiten"]);
            header("refresh:5; speisen.php");
            exit();
        } else {
            $daten_satz=$result->fetch_assoc();
        }
    }
}

if(!empty($_POST)){
    if($_POST["name"]=="" || $_POST["beschr"]=="" || $_POST["preis"]==""){
        $fehlermeldung="Bitte alle Felder ausfüllen !";
    } else if(!preg_match("/^\d+[\.,]?\d{0,2}?$/" ,$_POST["preis"])){
        $fehlermeldung="Der eingegebene Preis ist keine gültige Zahl! <br>Nur Zahlen, max. 2 Kommastellen und . oder ,";
    } else {
        // überprüfen ob sich etwas geändert hat, bin mir nicht ganz sicher ob das sinnvoll/zweckmässig ist?
        $sql_name=escape($_POST["name"]);
        $sql_beschr=escape($_POST["beschr"]);
        $sql_preis=punkt_statt_komma(escape($_POST["preis"]));
        if(!empty($_POST["aktiv"])) $aktiv=1; else $aktiv=0;
        $sql = "SELECT * from speisen where `name` ='{$sql_name}' and `beschreibung`='{$sql_beschr}' and `preis`='{$sql_preis}' and `aktiv`='$aktiv'";
        if($result=$con->query($sql)){ 
            if($result->num_rows != 0){//abfragen ob die Speise existiert
                $fehlermeldung="Speise existiert bereits oder es wurde nichts geändert!";
            } else {
                $sql="UPDATE speisen set `aktiv`='$aktiv', `name`='$sql_name', `beschreibung`='$sql_beschr', 
                `preis`='$sql_preis' where `id`= {$_SESSION["s_bearbeiten"]}; ";
                
                $result=$con->query($sql);

                $erfolg="Die Speise wurde erfolgreich eingetragen.";
                // variablen zurücksetzen
                unset($_POST["name"]);
                unset($_POST["beschr"]);
                unset($_POST["preis"]);
                unset($_POST["aktiv"]);
                unset($_SESSION["s_bearbeiten"]);
                // erfolgsmeldung an folgeseite übergeben.
                $_SESSION["erfolg"] ="Speise erfolgreich geändert";
                // umleiten auf die hauptseite
                header("location: speisen.php");
                exit();
            }

            $con->close();
        }
    }
}

if(!empty($fehlermeldung)){
    echo "<p style='color:red'>".$fehlermeldung."</p>";

}
// if(!empty($erfolg)){
//     echo "<p style='color:green'>".$erfolg."</p>";
//     header("refresh:5; speisen.php");
//     exit();
// }
?>

<form method='post'>
    <div>
        <label class="form_beschriftung" for="name">Name: </label>
        <input type="text" name="name" id="name" value="<?php if(!empty($daten_satz["name"])){ echo $daten_satz["name"];} ?> ">
    </div>
    <div>
        <label class="form_beschriftung" for="beschr">Beschreibung: </label>
        <input type="text" name="beschr" id="beschr" value="<?php if(!empty($daten_satz["beschreibung"])){ echo $daten_satz["beschreibung"];} ?> ">
    </div>
    <div>
        <label class="form_beschriftung" for="preis">Preis: </label>
        <input type="text" name="preis" id="preis" value="<?php if(!empty($daten_satz["preis"])) {echo $daten_satz["preis"];} ?>">
    </div>
    <div>
        <label class="form_beschriftung" for="aktiv">Ist diese Speise aktiv? </label>
        <input type="checkbox" name="aktiv" id="aktiv" <?php if(!empty($daten_satz["aktiv"])) {echo " checked ";} ?> >
    </div>

    <button type="submit">Speise ändern</button>
</form>



<?php


include "fuss.php";
