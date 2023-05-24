<?php
include "setup.php";

use WIFI\SK\Model\Row\Kat;
use WIFI\SK\Validieren;

include "kopf.php";



$fehler = new Validieren;

// sicherheitsüberprüfung ob die übergebene id existiert
if(!empty($_SESSION["k_bearbeiten"])){
    $kat = new Kat($_SESSION["k_bearbeiten"]);
    $tun="bearbeiten";
} else {
    $tun="hinzufügen";
}

echo "<h1>Kategorie {$tun} </h1>";

// Bearbeitete Kategorie wurde übergeben
if(!empty($_POST)){
    $fehler -> istAusgefuellt($_POST["name"],"Name");
    $fehler -> istAusgefuellt($_POST["beschr"],"Beschreibung");
    $fehler -> istAusgefuellt($_POST["typ"],"Typ");
    if(!empty($_POST["aktiv"])) $aktiv=1; else $aktiv=0;

    if(!$fehler->fehlerAufgetreten()){   //Felder dürfen nicht leer sein.

        // überprüfen ob sich etwas geändert hat, bin mir nicht ganz sicher ob das sinnvoll/zweckmässig ist?
        $kat_neu = new Kat(array(
            "kategorie_id" => $_SESSION["k_bearbeiten"] ?? null,
                // if(!empty($_GET["id"])) {"id" => $_GET["id"]} else {"id" => null}
            "name" => $_POST["name"],
            "beschreibung" => $_POST["beschr"],
            "typ" => $_POST["typ"],
            "aktiv" => $aktiv
        ));
  
        if((!empty($kat) && $kat->objektVerschieden($kat_neu)) || (empty($kat) && $kat_neu-> datensatzExistiertBereits())){//abfragen ob die geänderten Daten, sich tatsächlich geändert haben oder die neue Kategorie bereits in der DB existiert (Name, Beschreibung)
            $fehler-> fehlerDazu("Diese Kategorie existiert bereits oder es wurde nichts geändert!");
        } else {
            $kat_neu -> speichern();
            // variablen zurücksetzen
            unset($_POST["name"]);
            unset($_POST["beschr"]);
            unset($_SESSION["k_bearbeiten"]);
            // erfolgsmeldung an folgeseite übergeben.
            $_SESSION["erfolg"] ="Die Kategorie wurde erfolgreich geändert";
            // umleiten auf die hauptseite
            header("location: kategorie.php");
            exit();
        }
    }
}

if($fehler->fehlerAufgetreten()){
    echo "<p style='color:red'>".$fehler->fehlerAusgabeHtml()."</p>";

}
?>

<form method='post'>
    <div>
        <label class="form_beschriftung" for="name">Kategorie ausgeschrieben: </label>
        <input type="text" name="name" id="name" value="<?php if(!empty($kat)){ echo $kat -> getSpalte("name");} else if (!empty( $_POST["name"] )) {echo  $_POST["name"]; } ?>">
    </div>
    <div>
        <label class="form_beschriftung" for="beschr">Kategorie Beschreibung: </label>
        <input type="text" name="beschr" id="beschr" value="<?php if(!empty($kat)){ echo $kat -> getSpalte("beschreibung");}else if (!empty( $_POST["beschr"] )) {echo  $_POST["beschr"]; } ?>">
    </div>
    <div>
        <label class="form_beschriftung" for="typ">Typ:</label>
        <select name="typ" id="typ" size="3">
            <option value="" <?php if(empty($kat) || empty($_POST["typ"])) {echo ' selected ';} ?>>- Bitte wählen -</option>
            <option value="Getränk" <?php if(!empty($kat) && $kat -> getSpalte("typ")== 'Getränk') {echo ' selected ';} else if (!empty( $_POST["typ"] ) && $_POST["typ"] == "Getränk" ) {echo  " selected "; } ?>>Getränk</option>
            <option value="Speise" <?php if(!empty($kat) && !empty($kat -> getSpalte("typ")) && $kat -> getSpalte("typ")== 'Speise') {echo ' selected ';} else if (!empty( $_POST["typ"] ) && $_POST["typ"] == "Speise" ) {echo  " selected "; }?>>Speise</option>
        </select>
    </div>
    <div>
        <label class="form_beschriftung" for="aktiv">Ist diese Kategorie aktiv? </label>
        <input type="checkbox" name="aktiv" id="aktiv" <?php if(!empty($kat) && $daten_satz=1) {echo " checked ";} else if (!empty( $_POST["aktiv"] )) {echo  " checked "; } ?> >
    </div>

    <button type="submit">Kategorie speichern</button>
</form>
<?php
include "fuss.php";