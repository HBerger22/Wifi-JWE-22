<?php
include "funktionen.php";

include "kopf.php";

echo "<h1>Allergene bearbeiten</h1>";

// sicherheitsüberprüfung ob die übergebene id existiert
if(!empty($_SESSION["a_bearbeiten"])){
    $sql_id = escape($_SESSION["a_bearbeiten"]);
    $sql="SELECT * from allergene where `allergene_id`= {$sql_id};";
    if($result=$con->query($sql)){ 
        if($result->num_rows == 0){//abfragen ob das Allergen existiert
            $fehlermeldung="Dieses Allergen existiert nicht (mehr)!";
            unset($_SESSION["a_bearbeiten"]);
            header("refresh:5; allergen.php");
            exit();
        } else { // zum vorausfüllen des Formulars
            $daten_satz=$result->fetch_assoc();
        }
    }
}

// Bearbeitetes Allergen wurde übergeben
if(!empty($_POST)){
    if($_POST["name"]=="" || $_POST["beschr"]=="" || $_POST["klasse"]==""){ //Felder dürfen nicht leer sein.
        $fehlermeldung="Bitte alle Felder ausfüllen !";
    } else {
        // überprüfen ob sich etwas geändert hat, bin mir nicht ganz sicher ob das sinnvoll/zweckmässig ist?
        $sql_name=escape($_POST["name"]);
        $sql_beschr=escape($_POST["beschr"]);
        $sql_klasse=escape($_POST["klasse"]);
        $sql = "SELECT * from allergene where (`bezeichnung` ='{$sql_name}' and `beschreibung`='{$sql_beschr}' and `klasse`='{$sql_klasse}') or 
            ((`bezeichnung` ='{$sql_name}' or `beschreibung`='{$sql_beschr}' or `klasse`='{$sql_klasse}') and `allergene_id`!= {$sql_id} )";
        if($result=$con->query($sql)){ 
            if($result->num_rows != 0){//abfragen ob das Allergen bereits existiert
                $fehlermeldung="Dieses Allergen existiert bereits oder es wurde nichts geändert!";
                // unset($_SESSION["k_bearbeiten"]);
            } else {
                // if(!empty($_POST["aktiv"])) $aktiv=1; else $aktiv=0;
                $sql="UPDATE allergene set `bezeichnung`='$sql_name', `beschreibung`='$sql_beschr', `klasse` = '$sql_klasse' where `allergene_id`= {$sql_id}; ";
                
                $result=$con->query($sql);

                // $erfolg="Das Allergen wurde erfolgreich eingetragen.";
                // variablen zurücksetzen
                unset($_POST["name"]);
                unset($_POST["beschr"]);
                unset($_POST["klasse"]);
                unset($_SESSION["a_bearbeiten"]);
                // erfolgsmeldung an folgeseite übergeben.
                $_SESSION["erfolg"] ="Das Allergen wurde erfolgreich geändert";
                // umleiten auf die hauptseite
                header("location: allergene.php");
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
//     header("refresh:5; kategorie.php");
//     exit();
// }
?>


<form method='post'>
    <div>
        <label class="form_beschriftung" for="klasse">Allergen Klasse:</label>
        <input type="text" name="klasse" id="klasse" maxlength="5" value="<?php if(!empty($daten_satz["klasse"])){ echo $daten_satz["klasse"];} ?>">

    </div>    <div>
        <label class="form_beschriftung" for="name">Allergen Namen: </label>
        <input type="text" name="name" id="name" value="<?php if(!empty($daten_satz["bezeichnung"])){ echo $daten_satz["bezeichnung"];} ?>">
    </div>
    <div>
        <label class="form_beschriftung" for="beschr">Allergen Beschreibung: </label>
        
        <textarea name="beschr" id="beschr" cols="25" rows="5"><?php if(!empty($daten_satz["beschreibung"])){ echo $daten_satz["beschreibung"];} ?></textarea>
    </div>

    <!-- <div>
        <label class="form_beschriftung" for="aktiv">Ist diess Allergen aktiv? </label>
        <input type="checkbox" name="aktiv" id="aktiv" <?php if(!empty($_POST["aktiv"])) {echo " checked ";} ?> >
    </div> -->

    <button type="submit">Allergen ändern</button>
</form>



<?php


include "fuss.php";
