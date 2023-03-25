<?php
include "funktionen.php";


// $errors=array();
// $erfolg=false;


$sql_id = escape($_GET["id"]);
// prüfen ob das Formular abgeschickt wurde

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

        // UPDATE zutaten SET `kcal_pro_100` = '{$sql_kcal}', `name`='{$sql_name}'  WHERE `zutaten`.`id` = {$sql_id};");
        $sql="UPDATE passagiere SET `vorname` = '$sql_vorname', `nachname` = '$sql_nachname', `geb_datum` = '$sql_geb_datum', `flugangst` = '$sql_angst' where `passagier_id`= {$sql_id}";
        query($sql);
        unset($_POST["vorname"]);
        unset($_POST["nachname"]);
        unset($_POST["geb_datum"]);
        unset($_POST["angst"]);
        $erfolg="Passagier erfolgreich geändert.";
    }
    
}







include "kopf.php";

if(!empty($error))
echo "<p style='color : red'> $error </p>";

if(!empty($erfolg))
echo "<p style='color : green'> $erfolg </p>";
?>


    <h1>Passagier bearbeiten</h1>
<?php
    // if( $erfolg ){
       
    // }     
    
    if( !empty($errors) ){
        echo "<ul>";
        foreach ($errors as $key => $e){
            echo "<li> {$e} </li>";
        }
        echo "</ul>";
        // echo "<p style='color:red'> $error </p>";
    }

    // DB nach Zutat-Datensatz fragen zur vorbefüllung
    $result = query("SELECT * FROM passagiere where passagier_id='{$sql_id}'");
    $row = fetch($result);
    

?>

<form method="post">
        <div>
            <label for="vorname"> Vornamen eingeben: </label>
            <input type="text" name="vorname" id="vorname" value="<?php if(!empty($_post["vorname"])) {
                    echo htmlspecialchars($_POST['vorname']);
                } else{
                    echo htmlspecialchars($row['vorname']);
                } ?>">
        </div>
        <div>
            <label for="nachname"> Nachnamen eingeben: </label>
            <input type="text" name="nachname" id="nachname" value="<?php if(!empty($_post["nachname"])) {
                    echo htmlspecialchars($_POST['nachname']);
                } else{
                    echo htmlspecialchars($row['nachname']);
                } ?>">
        </div>        
        <div>
            <label for="geb_datum"> Geburtsdatum eingeben: </label>
            <input type="date" name="geb_datum" id="geb_datum" value="<?php if(!empty($_post["geb_datum"])) {
                    echo htmlspecialchars($_POST['geb_datum']);
                } else{
                    echo htmlspecialchars($row['geb_datum']);
                } ?>">
        </div>
        <div>
            <label for="angst"> Haben sie Flugangst: </label>
            <input type="checkbox" name="angst" id="angst" value="1"<?php if(!empty($_POST["angst"])) {
                echo 'checked';
                } else if($row["flugangst"]){ 
                    echo 'checked';
                } ?>>
        </div>
        <div>
            <button type="submit">Passagier ändern</button>
        </div>
    </form>

<?php
include "fuss.php";