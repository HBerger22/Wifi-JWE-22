<?php
include "funktionen.php";
ist_eingeloggt();
$erfolg=false;

echo "<pre>";
print_r($_POST);
echo "</pre>";

if(!empty($_POST)){
    if(empty($_POST["titel"])){
        $error = "Name darf nicht leer sein!";
    } else {
        $sql_titel = escape($_POST["titel"]);
        $sql_beschr = escape($_POST["beschr"]);
        $sql_ben_id = escape($_POST["benutzer_id"]);

        $result = query("SELECT * FROM rezepte WHERE `titel` ='{$sql_titel}'");
        $row = fetch($result);

        // Rezepte können im Gegensatz zu Zutaten öfters vorkommen.
        // if($row){
        //     $error ="Dieses Rezept existiert bereits!"; 
        // }
    }

    // benutzer fix ausgewählt vom eingeloggten User abgeleitet.
    // $result2 = query("SELECT id from benutzer where `benutzername`='{$_SESSION["benutzername"]}'");
    // $row2=fetch($result2);
    // $sql_ben_id = escape($row2["id"]);

// var_dump($error);
    if (empty($error)){
        if(empty($sql_beschr)){
            $sql_beschr="NULL";
        }
        query("INSERT into rezepte ( titel , beschreibung, benutzer_id) VALUES ('{$sql_titel}', '{$sql_beschr}', '{$sql_ben_id}')");
        unset($_POST["titel"]);
        unset($_POST["beschr"]);
        
        $erfolg=true;
    }
}

    // $error = "nicht leer";

include "kopf.php";
?>


    <h1>Neues Rezept anlegen:</h1>
<?php
    if( !empty($error) ){
        echo "<p style='color:red'> $error </p>";
    }
    if( $erfolg ){
        echo "<p style='color:green'> Rezept erfolgreich eingetragen <br> 
            <a href='rezepte_liste.php'>Zutaten Liste</a> </p>";
    } 
?>

    <form method="post">
        <div>
            <label for="benutzer_id"> Benutzer: </label>
            <select name="benutzer_id" id="benutzer_id">
                <?php
                    $result2 = query("SELECT id, benutzername from benutzer order by 'benutzername' asc");
                    while($row2=fetch($result2)){
                        echo "<option value='{$row2["id"]}'";
                        if(!empty($_POST["benutzer_id"])  && !$erfolg && $_POST["benutzer_id"]==$row2["id"]){
                            echo " selected ";
                        } else if((empty($_POST["benutzer_id"])  || $erfolg) && $_SESSION["benutzer_id"]==$row2["id"]){
                            echo " selected ";
                        }

                        echo ">{$row2["benutzername"]}</option>";
                    }
                ?>
            </select>

        </div>
        <div>
            <label for="titel"> Titel: </label>
            <input type="text" name="titel" id="titel" value="<?php if(!empty($_POST["titel"])) {
                echo htmlspecialchars($_POST['titel']);
                } ?>">
        </div>
        <div>
            <label for="beschr"> Beschreibung </label>
            <textarea name="beschr" id="beschr" ><?php if(isset($_POST["beschr"])) {
                echo htmlspecialchars($_POST['beschr']);
                } ?> </textarea>
        </div>

        <!-- Zutaten m-n -->
        <div class="zutatenliste">
            <?php
                // Ermitteln Wieviele Blöcke wir brauchen
            $bloecke=1;
            if(!empty($_POST["zutaten_id"]) && !$erfolg) {
                $bloecke = count($_POST["zutaten_id"]);
            }

            for($i=0 ; $i < $bloecke; $i++){
            ?>
            <div class="zutatenblock">
                <div>
                    <label for="zutat_id">Zutat:</label>
                    <select name="zutaten_id" id="zutaten_id">
                        <option value=''>-Bitte wählen-</option>
                        <?php
                            $result = query("SELECT * from `zutaten` order by 'name' asc");
                            while ($zutat=fetch($result)){
                                echo "<option value='{$zutat["id"]}'";
                                if(!empty($_POST["zutaten_id"])  && !$erfolg && $_POST["zutaten_id"]==$zutat["id"]){
                                    echo " selected ";
                                }
                                echo ">{$zutat["name"]}</option>";
                            }
                        ?>
                    </select>

                </div>
                <div>
                    <label for="menge">Menge: </label>
                    <input type="number" name="menge[]" id="menge" value=" <?php
                        if(!empty($_POST["menge"])) {
                            echo htmlspecialchars($_POST['menge']);
                            }
                    ?>">
                </div>
                <div>
                    <label for="einheit">Einheit: </label>
                    <input type="text" name="einheit[]" id="einheit" value=" <?php
                        if(!empty($_POST["einheit"])) {
                            echo htmlspecialchars($_POST['einheit']);
                            }
                    ?>">
                </div>
            </div>   
            <?php 
            } ?>
        </div>
     
        <a class="zutat_neu" href="#" onclick="neueZutat();">Zutat hinzufügen</a>

        <div>
            <button type="submit">Rezept hinzufügen</button>
        </div>
    
    </form>

<?php
include "fuss.php";