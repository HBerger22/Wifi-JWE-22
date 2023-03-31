<?php
include "funktionen.php";

include "kopf.php";

echo "<h1>Einheit bearbeiten</h1>";

// sicherheitsüberprüfung ob die übergebene id existiert
if(!empty($_SESSION["e_bearbeiten"])){
    $sql_id = escape($_SESSION["e_bearbeiten"]);
    $sql="SELECT * from einheit where `einheit_id`= {$sql_id};";
    if($result=$con->query($sql)){ 
        if($result->num_rows == 0){//abfragen ob die Einheit existiert
            $fehlermeldung="Diese Einheit existiert nicht (mehr)!";
            unset($_SESSION["e_bearbeiten"]);
            header("refresh:5; einheiten.php");
            exit();
        } else { // zum vorausfüllen des Formulars
            $daten_satz=$result->fetch_assoc();
        }
    }
}

// Bearbeitete Einheit wurde übergeben
if(!empty($_POST)){
    if($_POST["name"]=="" || $_POST["kuerzel"]==""){ //Felder dürfen nicht leer sein.
        $fehlermeldung="Bitte alle Felder ausfüllen !";
    } else {
        // überprüfen ob sich etwas geändert hat, bin mir nicht ganz sicher ob das sinnvoll/zweckmässig ist?
        $sql_name=escape($_POST["name"]);
        $sql_kuerzel=escape($_POST["kuerzel"]);
        $sql = "SELECT * from einheit where (`name` ='{$sql_name}' and `kuerzel`='{$sql_kuerzel}') or 
            ((`name` ='{$sql_name}' or `kuerzel`='{$sql_kuerzel}') and `einheit_id`!= {$sql_id} )";
        if($result=$con->query($sql)){ 
            if($result->num_rows != 0){//abfragen ob die Einheit existiert
                $fehlermeldung="Diese/s Einheit/Kürzel existiert bereits oder es wurde nichts geändert!";
                unset($_SESSION["e_bearbeiten"]);
            } else {
                $sql="UPDATE einheit set `name`='$sql_name', `kuerzel`='$sql_kuerzel' where `einheit_id`= {$sql_id}; ";
                
                $result=$con->query($sql);

                // $erfolg="Die Einheit wurde erfolgreich eingetragen.";
                // variablen zurücksetzen
                unset($_POST["name"]);
                unset($_POST["kuerzel"]);
                unset($_SESSION["e_bearbeiten"]);
                // erfolgsmeldung an folgeseite übergeben.
                $_SESSION["erfolg"] ="Die Einheit wurde erfolgreich geändert";
                // umleiten auf die hauptseite
                header("location: einheiten.php");
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
//     header("refresh:5; einheiten.php");
//     exit();
// }
?>

<form method='post'>
    <div>
        <label class="form_beschriftung" for="name">Einheit ausgeschrieben: </label>
        <input type="text" name="name" id="name" value="<?php if(!empty($daten_satz["name"])){ echo $daten_satz["name"];} ?>">
    </div>
    <div>
        <label class="form_beschriftung" for="kuerzel">Einheit Kürzel: </label>
        <input type="text" name="kuerzel" id="kuerzel" value="<?php if(!empty($daten_satz["kuerzel"])){ echo $daten_satz["kuerzel"];} ?>">
    </div>
    <button type="submit">Einheit ändern</button>
</form>



<?php


include "fuss.php";
