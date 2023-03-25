<?php
include "funktionen.php";


include "kopf.php";
echo "<h1>Flug entfernen</h1>";

$sql_pass_id = escape($_GET["id"]);



// hat der passagier einen Flug gebucht.

$result=query("SELECT * from bz_passagier_zu_fluege where passagier_id='{$sql_pass_id}'");
if(!fetch($result)){
    echo "<p style='color : red'> Zu diesem Passagier gibt es keine Flüge </p>";
} else if(!empty($_POST)) { 
    if(!empty($_POST["flug_id"])){
        $sql_flug_id=escape($_POST["flug_id"]);

        // hat der benutzer bestätigt?
        if(!empty($_POST["sicher"])){
            query("DELETE FROM `bz_passagier_zu_fluege` WHERE fluege_id={$sql_flug_id} and passagier_id = {$sql_pass_id}");
            echo " Flug wurde erfolgreich gelöscht";
        } else {




            $result2 = query("SELECT * from `bz_passagier_zu_fluege` where fluege_id={$sql_flug_id} and passagier_id = {$sql_pass_id}");
            $existiert = fetch($result2);


            if(!$existiert){ //die verknüpfung existiert nicht
                echo "<pstyle='color : red'> Der Flug existiert nicht (mehr)!";
            } else { //Benutzer fragen ob wirklich löschen?
                echo "<p> Wollen sie den Flug wirklich endgültig löschen?</p>";
                echo "<p> 
                        <a href='passagier_liste.php'>Nein, abbrechen</a> <br>
                        <form method='post'>
                        
                        <button type='submit' name='sicher' id='sicher' value='1'>Ja bitte</button>
                        <input type='checkbox' name='flug_id' id='flug_id' checked value='{$sql_flug_id}' >
                    
                    
                        </form> 
                    </p>";
            } 
        }


    } else {
        echo "<p style='color : red'> Bitte einen Flug auswählen </p>";
     
    }



} else {
    




if(!empty($error))
echo "<p style='color : red'> $error </p>";

if(!empty($erfolg))
echo "<p style='color : green'> $erfolg </p>";

?>
    
    <form method="post">
        <div>
            <label for="flug_id">Flug auswählen:</label>
            <select name="flug_id" id="flug_id">
                <option value=''>-Bitte wählen-</option>
                <?php
                    $result=query("SELECT * FROM `bz_passagier_zu_fluege` bz join `fluege` on fluege.id= bz.fluege_id 
                            WHERE bz.passagier_id = '{$sql_pass_id}' order by flugnr asc" );
                    while ($flug=fetch($result)){
                        echo "<option value='{$flug["id"]}'";
                       echo ">{$flug["flugnr"]} nach {$flug["ziel_flgh"]}</option>";
                    }
                ?>
        </select>
        </div>
        <div>
            <button type="submit">Flug stornieren</button>
        </div>

    </form>



<?php
}
include "fuss.php";
?>