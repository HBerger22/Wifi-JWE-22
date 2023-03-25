<?php
include "funktionen.php";
include "kopf.php";
?>
    <h1>Passagier anlegen</h1>

<?php




    if(!empty($_POST)){
        if(empty($_POST["vorname"]) || empty($_POST["nachname"]) || empty($_POST["geb_datum"]) ){
            $error="Bitte füllen sie Vorname, Nachname und Geburtsdatum aus!";
        } else {
            $sql_vorname= escape($_POST["vorname"]);
            $sql_nachname= escape($_POST["nachname"]);
            $sql_geb_datum= escape($_POST["geb_datum"]);
            if(!empty($_POST["angst"])){
                $sql_angst = 1;
            } else {
                $sql_angst = 0;
            }
            $sql="INSERT INTO `passagiere`(`vorname`, `nachname`, `geb_datum`, `flugangst`) 
            VALUES ('$sql_vorname','$sql_nachname','$sql_geb_datum','$sql_angst')";
            query($sql);
            unset($_POST["vorname"]);
            unset($_POST["nachname"]);
            unset($_POST["geb_datum"]);
            unset($_POST["angst"]);
            $erfolg="Passagier erfolgreich eingetragen.";
        }
        
    }

    if(!empty($error))
    echo "<p style='color : red'> $error </p>";

    if(!empty($erfolg))
    echo "<p style='color : green'> $erfolg </p>";


?>


    <form method="post">
        <div>
            <label for="vorname"> Vornamen eingeben: </label>
            <input type="text" name="vorname" id="vorname" value="<?php if(!empty($_POST["vorname"])) {
                echo htmlspecialchars($_POST['vorname']);
                } ?>">
        </div>
        <div>
            <label for="nachname"> Nachnamen eingeben: </label>
            <input type="text" name="nachname" id="nachname" value="<?php if(!empty($_POST["nachname"])) {
                echo htmlspecialchars($_POST['nachname']);
                } ?>">
        </div>        
        <div>
            <label for="geb_datum"> Geburtsdatum eingeben: </label>
            <input type="date" name="geb_datum" id="geb_datum" value="<?php if(!empty($_POST["geb_datum"])) {
                echo htmlspecialchars($_POST['geb_datum']);
                } ?>">
        </div>
        <div>
            <label for="angst"> Haben sie Flugangst: </label>
            <input type="checkbox" name="angst" id="angst" value="1"<?php if(!empty($_POST["angst"])) {
                echo 'checked';
                } ?>>
        </div>
        <div>
            <button type="submit">Passagier hinzufügen</button>
        </div>
    </form>







<?php
// }
include "fuss.php";
?>
