<?php
include "funktionen.php";

include "kopf.php";

echo "<h1>Speise hinzufügen</h1>";

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
    if(empty($_POST["name"]) || empty($_POST["beschr"]) || empty($_POST["preis"]) || empty($_POST["kategorie"]) ){
        $fehlermeldung="Bitte alle Felder ausfüllen !";
    } else if(!preg_match("/^\d+[\.,]?\d{0,2}?$/" ,$_POST["preis"])){
        $fehlermeldung="Der eingegebene Preis ist keine gültige Zahl! <br>Nur Zahlen, max. 2 Kommastellen und . oder ,";
    } else {
        $sql_name=escape($_POST["name"]);
        $sql = "SELECT * from speise where `name` ='{$sql_name}'";
        if($result=$con->query($sql)){ 
            if($result->num_rows != 0){//abfragen ob der Speise existiert
                $fehlermeldung="Diese Speise existiert bereits!";
            } else {
            // übernahme Parameter
                $sql_beschr = escape( $_POST["beschr"] );
                $sql_preis = punkt_statt_komma( escape($_POST["preis"]) );
                $sql_kat_id = escape( $_POST["kategorie"] );
                if( !empty($_POST["aktiv"]) ) $aktiv=1; else $aktiv=0;
            // eintragen in Tabelle Speisen
                $sql="INSERT into speise (`aktiv`, `name`, `beschreibung`)
                    VALUES ('$aktiv','$sql_name','$sql_beschr') ";
                $result=$con->query($sql);
                
                // abfragen der neu eingefügten speisenid
                $speisenId=mysqli_insert_id($con);
              
            // Speise der Kategorie zuordnen und Preis eintragen (bz_speise_kategorie)
                $sql="INSERT into bz_speise_kategorie (`speisen_id`, `kategorie_id`, `preis`)
                VALUES ('$speisenId','$sql_kat_id','$sql_preis')";
                $con->query($sql);

                $erfolg="Die Speise wurde erfolgreich hinzugefügt.";
                unset($_POST["name"]);
                unset($_POST["beschr"]);
                unset($_POST["preis"]);
                unset($_POST["aktiv"]);
                unset($_POST["kategorie"]);
            }

            // $con->close();
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
        <label class="form_beschriftung" for="name">Name: </label>
        <input type="text" name="name" id="name" value="<?php if(!empty($_POST["name"])){ echo $_POST["name"];} ?>">
    </div>
    <div>
        <label class="form_beschriftung" for="beschr">Beschreibung: </label>
        <input type="text" name="beschr" id="beschr" value="<?php if(!empty($_POST["beschr"])){ echo $_POST["beschr"];} ?>">
    </div>
    <div>
        <label class="form_beschriftung" for="preis">Preis: </label>
        <input type="number" step="0.01" name="preis" id="preis" value="<?php if(!empty($_POST["preis"])) {echo $_POST["preis"];} ?>">
    </div>
    <div>
        <label class="form_beschriftung" for="kategorie[]">Kategorie:</label>
        <select name="kategorie" size="5"> <!-- [] multiple ?-->
            <option selected value="">-- Bitte auswählen --</option>
            <?php
                $sql="SELECT * from `kategorie` where `typ`='Speise' order by 'name' asc";
                $result_kat=$con->query($sql);
                
                while ($kat=fetch($result_kat)){
                    echo "<option value='{$kat["kategorie_id"]}'";
                    if(!empty($_POST["kategorie"]) && $_POST["kategorie"]==$kat["kategorie_id"] ){
                        echo " selected ";
                    }
                    echo ">{$kat["name"]}</option>";
                }
            ?>
        </select>
    </div>
    <div>
        <label class="form_beschriftung" for="aktiv">Ist diese Speise aktiv? </label>
        <input type="checkbox" name="aktiv" id="aktiv" <?php if(!empty($_POST["aktiv"])) {echo " checked ";} ?> >
    </div>

    <button type="submit">Speise hinzufügen</button>
</form>



<?php


include "fuss.php";
