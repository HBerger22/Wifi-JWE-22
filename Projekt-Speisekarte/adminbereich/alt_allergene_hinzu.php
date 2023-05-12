<?php
include "funktionen.php";

include "kopf.php";

echo "<h1>Allergene hinzufügen</h1>";

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

if(!empty($_POST)){
    if( empty($_POST["name"]) || empty($_POST["beschr"]) || empty($_POST["klasse"]) ){
        $fehlermeldung="Bitte alle Felder ausfüllen !";
    } else {
        $sql_klasse=escape($_POST["klasse"]);
        $sql_name=escape($_POST["name"]);
        $sql = "SELECT * from allergene where `bezeichnung` ='{$sql_name}' or `klasse`='{$sql_klasse}'";
        if($result=$con->query($sql)){ 
            if($result->num_rows != 0){//abfragen ob die Allergie existiert
                $fehlermeldung="Dieses Allergen existiert bereits!";
            } else {
                $sql_beschr=escape($_POST["beschr"]);
                // if(!empty($_POST["aktiv"])) $aktiv=1; else $aktiv=0;
                $sql="INSERT into Allergene ( `bezeichnung`, `beschreibung`, `klasse`)
                    VALUES ('$sql_name','$sql_beschr', '$sql_klasse') ";
                $result=$con->query($sql);
                $erfolg="Das Allergen wurde erfolgreich hinzugefügt.";
                unset($_POST["name"]);
                unset($_POST["beschr"]);
                unset($_POST["klasse"]);
            }

            $con->close();
        }
    }
}

if(!empty($fehlermeldung)){
    echo "<p style='color:red'>".$fehlermeldung."</p>";

}

if(!empty($erfolg)){
    echo "<p style='color:green'>".$erfolg."</p>";

}
?>

<form method='post'>
    <div>
        <label class="form_beschriftung" for="klasse">Allergen Klasse:</label>
        <input type="text" name="klasse" id="klasse" maxlength="5" value="<?php if(!empty($_POST["klasse"])){ echo $_POST["klasse"];} ?>">

    </div>    <div>
        <label class="form_beschriftung" for="name">Allergen Namen: </label>
        <input type="text" name="name" id="name" value="<?php if(!empty($_POST["name"])){ echo $_POST["name"];} ?>">
    </div>
    <div>
        <label class="form_beschriftung" for="beschr">Allergen Beschreibung: </label>
        
        <textarea name="beschr" id="beschr" cols="25" rows="5"><?php if(!empty($_POST["beschr"])){ echo $_POST["beschr"];} ?></textarea>
    </div>

    <!-- <div>
        <label class="form_beschriftung" for="aktiv">Ist diess Allergen aktiv? </label>
        <input type="checkbox" name="aktiv" id="aktiv" <?php if(!empty($_POST["aktiv"])) {echo " checked ";} ?> >
    </div> -->

    <button type="submit">Allergen hinzufügen</button>
</form>



<?php


include "fuss.php";
