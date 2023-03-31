<?php
include "funktionen.php";

include "kopf.php";

echo "<h1>Kategorie hinzufügen</h1>";

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
    if( empty($_POST["name"]) || empty($_POST["beschr"]) ){
        $fehlermeldung="Bitte alle Felder ausfüllen !";
    } else {
        $sql_name=escape($_POST["name"]);
        $sql = "SELECT * from kategorie where `name` ='{$sql_name}'";
        if($result=$con->query($sql)){ 
            if($result->num_rows != 0){//abfragen ob der Kategorie existiert
                $fehlermeldung="Diese Kategorie existiert bereits!";
            } else {
                $sql_beschr=escape($_POST["beschr"]);
                if(!empty($_POST["aktiv"])) $aktiv=1; else $aktiv=0;
                $sql="INSERT into kategorie (`aktiv`, `name`, `beschreibung`)
                    VALUES ('$aktiv','$sql_name','$sql_beschr') ";
                $result=$con->query($sql);
                $erfolg="Die Kategorie wurde erfolgreich hinzugefügt.";
                unset($_POST["name"]);
                unset($_POST["beschr"]);
                unset($_POST["aktiv"]);
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
        <label class="form_beschriftung" for="name">Kategorie Namen: </label>
        <input type="text" name="name" id="name" value="<?php if(!empty($_POST["name"])){ echo $_POST["name"];} ?>">
    </div>
    <div>
        <label class="form_beschriftung" for="beschr">Kategorie Beschreibung: </label>
        <input type="text" name="beschr" id="beschr" value="<?php if(!empty($_POST["beschr"])){ echo $_POST["beschr"];} ?>">
    </div>
    <div>
        <label class="form_beschriftung" for="aktiv">Ist diese Kategorie aktiv? </label>
        <input type="checkbox" name="aktiv" id="aktiv" <?php if(!empty($_POST["aktiv"])) {echo " checked ";} ?> >
    </div>

    <button type="submit">Kategorie hinzufügen</button>
</form>



<?php


include "fuss.php";
