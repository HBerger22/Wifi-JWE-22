<?php
include "setup.php";

use WIFI\SK\Model\Row\Einheit;
use WIFI\SK\Validieren;

include "kopf.php";

$fehler = new Validieren;

// sicherheitsüberprüfung ob die übergebene id existiert
if(!empty($_SESSION["e_bearbeiten"])){
    $einheit = new Einheit($_SESSION["e_bearbeiten"]);
    $tun = "bearbeiten";
} else{
    $tun = "hinzufügen";
}

echo "<h1>Einheit {$tun} </h1>";

// Bearbeitete oder neue Einheit wurde übergeben
if(!empty($_POST)){
    $fehler -> istAusgefuellt($_POST["name"],"Name");
    $fehler -> istAusgefuellt($_POST["kuerzel"],"Kuerzel");
    if (!$fehler->fehlerAufgetreten()){
        $einheitNeu = new Einheit(array(
            "einheit_id" => $_SESSION["e_bearbeiten"] ?? null,
            "name" => $_POST["name"],
            "kuerzel" => $_POST["kuerzel"]
        ));
   
        // überprüfen ob sich etwas geändert hat, bin mir nicht ganz sicher ob das sinnvoll/zweckmässig ist?
            if(!empty($einheit) && $einheit -> objektVerschieden($einheitNeu) || (empty($einheit) && $einheitNeu-> datensatzExistiertBereits()) ){//abfragen ob die Einheit existiert
                $fehler->fehlerDazu("Diese/s Einheit/Kürzel existiert bereits oder es wurde nichts geändert!");
            } else {
                $einheitNeu -> speichern();

                // variablen zurücksetzen
                unset($_POST["name"]);
                unset($_POST["kuerzel"]);
                unset($_SESSION["e_bearbeiten"]);
                // erfolgsmeldung an folgeseite übergeben.
                $_SESSION["erfolg"] ="Die Einheit wurde erfolgreich gespeichert";
                // umleiten auf die hauptseite
                header("location: einheiten.php");
                exit();
            }

    }
}

if(!empty($fehler->fehlerAufgetreten())){
    echo "<p style='color:red'>".$fehler->fehlerAusgabeHtml()."</p>";

}
?>

<form method='post'>
    <div>
        <label class="form_beschriftung" for="name">Einheit ausgeschrieben: </label>
        <input type="text" name="name" id="name" value="<?php if(!empty($einheit)){ echo $einheit -> getSpalte("name");}else if (!empty( $_POST["name"] )) {echo  $_POST["name"]; }  ?>">
    </div>
    <div>
        <label class="form_beschriftung" for="kuerzel">Einheit Kürzel: </label>
        <input type="text" name="kuerzel" id="kuerzel" value="<?php if(!empty($einheit)){ echo $einheit -> getSpalte("kuerzel");}else if (!empty( $_POST["kuerzel"] )) {echo  $_POST["kuerzel"]; } ?>">
    </div>
    <button type="submit">Einheit speichern</button>
</form>
<?php
include "fuss.php";