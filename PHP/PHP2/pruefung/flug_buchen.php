<?php
include "funktionen.php";
include "kopf.php";
?>
    <h1>Flug buchen</h1>

<?php

if(!empty($_POST)){
    $sql_pass_id=escape($_POST["pass_id"]);
    $sql_flug_id=escape($_POST["flug_id"]);
    if(empty($_POST["pass_id"])||empty($_POST["flug_id"])){
        $error="Bitte alle Felder ausfüllen";
    } else {
        $result=query("SELECT * from `bz_passagier_zu_fluege` where passagier_id='{$sql_pass_id}' and `fluege_id`='{$sql_flug_id}'");
        if(fetch($result)){
            $error="Dieser Flug wurde bereits gebucht, bitte buchen sie einen anderen!";
        } else {
            query("INSERT INTO `bz_passagier_zu_fluege`( `passagier_id`, `fluege_id`) VALUES ('{$sql_pass_id}','{$sql_flug_id}');");
            unset($_POST["flug_id"]);

            $erfolg= "Flug wurde erfolgreich gebucht!";
        }
    }


}
    

if(!empty($error))
echo "<p style='color : red'> $error </p>";

if(!empty($erfolg))
echo "<p style='color : green'> $erfolg </p>";

?>
    
    <form method="post">
        <div>
            <label for="pass_id">Passagier</label>
            <select name="pass_id" id="pass_id">
                <option value=''>-Bitte wählen-</option>
                <?php
                    $result=query("SELECT * from passagiere order by nachname asc");
                    while ($pass=fetch($result)){
                        echo "<option value='{$pass["passagier_id"]}'";
                        if(!empty($_POST["pass_id"])   && $_POST["pass_id"]==$pass["passagier_id"]){ //&& !$erfolg
                            echo " selected ";
                        }
                        echo ">{$pass["vorname"]} {$pass["nachname"]}</option>";
                    }
                ?>
        </select>
        </div>
        <div>
            <label for="flug_id">Zutat:</label>
            <select name="flug_id" id="flug_id">
                <option value=''>-Bitte wählen-</option>
                <?php
                    $result=query("SELECT * from fluege order by flugnr asc" );
                    while ($flug=fetch($result)){
                        echo "<option value='{$flug["id"]}'";
                       
                        echo ">{$flug["flugnr"]} nach {$flug["ziel_flgh"]}</option>";
                    }
                ?>
        </select>
        </div>
        <div>
            <button type="submit">Flug buchen</button>
        </div>

    </form>









<?php
include "fuss.php";
?>
