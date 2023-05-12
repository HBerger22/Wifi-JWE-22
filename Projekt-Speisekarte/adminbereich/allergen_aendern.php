<?php
include "setup.php";

use WIFI\SK\Model\Row\Allergen;
use WIFI\SK\Validieren;

include "kopf.php";

$fehler = new Validieren;

// sicherheitsüberprüfung ob die übergebene id existiert
if(!empty($_SESSION["a_bearbeiten"])){
    $allergen = new Allergen($_SESSION["a_bearbeiten"]);
    $tun = "bearbeiten";
} else{
    $tun = "hinzufügen";
}

echo "<h1>Allergen {$tun} </h1>";

// Bearbeitete oder neue Einheit wurde übergeben
if(!empty($_POST)){
    $fehler -> istAusgefuellt($_POST["name"],"Name");
    $fehler -> istAusgefuellt($_POST["klasse"],"Klasse");
    $fehler -> istAusgefuellt($_POST["beschr"],"Beschreibung");
    if (!$fehler->fehlerAufgetreten()){
        $allergenNeu = new Allergen(array(
            "allergen_id" => $_SESSION["a_bearbeiten"] ?? null,
            "name" => $_POST["name"],
            "beschreibung" => $_POST["beschr"],
            "klasse" => $_POST["klasse"]
        ));

   
        // überprüfen ob sich etwas geändert hat, bin mir nicht ganz sicher ob das sinnvoll/zweckmässig ist?
            if(!empty($allergen) && $allergen -> objektVerschieden($allergenNeu) || (empty($allergen) && $allergenNeu-> datensatzExistiertBereits()) ){//abfragen ob die Einheit existiert
                $fehler->fehlerDazu("Diese/s Einheit/Kürzel existiert bereits oder es wurde nichts geändert!");
                // unset($_SESSION["e_bearbeiten"]);
            } else {
                $allergenNeu -> speichern();
                // $sql="UPDATE einheit set `name`='$sql_name', `kuerzel`='$sql_kuerzel' where `einheit_id`= {$sql_id}; ";
                
                // $result=$con->query($sql);

                // $erfolg="Die Einheit wurde erfolgreich eingetragen.";
                // variablen zurücksetzen
                unset($_POST["name"]);
                unset($_POST["klasse"]);
                unset($_POST["beschr"]);
                unset($_SESSION["a_bearbeiten"]);
                // erfolgsmeldung an folgeseite übergeben.
                $_SESSION["erfolg"] ="Die Einheit wurde erfolgreich gespeichert";
                // umleiten auf die hauptseite
                header("location: allergene.php");
                exit();
            }

            // $con->close();
        // }
    }
}

if(!empty($fehler->fehlerAufgetreten())){
    echo "<p style='color:red'>".$fehler->fehlerAusgabeHtml()."</p>";

}
// if(!empty($erfolg)){
//     echo "<p style='color:green'>".$erfolg."</p>";
//     header("refresh:5; einheiten.php");
//     exit();
// }
?>

<form method='post'>
<div>
        <label class="form_beschriftung" for="klasse">Allergen Kürzel: </label>
        <input type="text" name="klasse" id="klasse" value="<?php if(!empty($allergen)){ echo $allergen -> getSpalte("klasse");}else if (!empty( $_POST["klasse"] )) {echo  $_POST["klasse"]; } ?>">
    </div>
    <div>
        <label class="form_beschriftung" for="name">Allergen ausgeschrieben: </label>
        <input type="text" name="name" id="name" value="<?php if(!empty($allergen)){ echo $allergen -> getSpalte("name");}else if (!empty( $_POST["name"] )) {echo  $_POST["name"]; }  ?>">
    </div>
    <div>
        <label class="form_beschriftung" for="beschr">Allergen Beschreibung: </label>
        <textarea name="beschr" id="beschr" cols="25" rows="5"><?php if(!empty($allergen)){ echo $allergen -> getSpalte("beschreibung");}else if (!empty( $_POST["beschr"] )) {echo  $_POST["beschr"]; } ?></textarea>
    </div>
    <button type="submit">Allergen speichern</button>
</form>



<?php


include "fuss.php";
