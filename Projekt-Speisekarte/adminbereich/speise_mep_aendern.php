<?php

use WIFI\SK\Model\BzEinheit;
use WIFI\SK\Model\Einheiten;
use WIFI\SK\Model\Row\Speise;
use WIFI\SK\Model\Row\Kat;
use WIFI\SK\Validieren;

use function WIFI\SK\zwei_kommastellen;
use function WIFI\SK\punkt_statt_komma;
use function WIFI\SK\komma_statt_punkt;

include "setup.php";
include "funktionen.php";


include "kopf.php";

$fehler = new Validieren;

$bzMep=new BzEinheit($_SESSION["s_id_mep"],$_SESSION["objekt"]);
$einheiten = new Einheiten();
$alleEinheiten = $einheiten->alleElemente();

$produkt= $bzMep->getSpeise();

// sicherheitsüberprüfung ob die übergebene id existiert
if(!empty($_SESSION["mep_bearbeiten"])){
    $mepDatensatz = $bzMep -> getEinzelnenMep($_SESSION["mep_bearbeiten"]);
    $tun="bearbeiten";
} else {
    $tun="hinzufügen";
}

echo "<h1>Menge/Einheit/Preis {$tun} </h1>";
echo "<h3>".$produkt["name"]."</h3>";
// Bearbeitete Kategorie wurde übergeben
if(!empty($_POST)){
    $fehler -> istAusgefuellt($_POST["menge"],"Menge");
    $fehler -> istAusgefuellt($_POST["einheit"],"Einheit");
    $fehler -> istAusgefuellt($_POST["preis"],"Preis");
    if(!empty($_POST["aktiv"])) $aktiv=1; else $aktiv=0;

    if(!$fehler->fehlerAufgetreten()){   //Felder dürfen nicht leer sein.

        // überprüfen ob sich etwas geändert hat, bin mir nicht ganz sicher ob das sinnvoll/zweckmässig ist?
        $datensatz=array(
            "bz_sk_id" => $_SESSION["mep_bearbeiten"] ?? null,
            "kategorie_id" => $bzMep->getKatId(),
            "einheit_id" => $_POST["einheit"],
            "menge" => $_POST["menge"],
            "aktiv" => $aktiv,
            "preis" => $_POST["preis"]
            
        );
        if(!$bzMep->mepVerschieden($datensatz) ){//abfragen ob die geänderten Daten, sich tatsächlich geändert haben oder die neue Kategorie bereits in der DB existiert (Name, Beschreibung)
            $fehler-> fehlerDazu("Diese Menge/Einheit/Preis existiert bereits oder es wurde nichts geändert!");
        } else {
            $bzMep -> speichern($datensatz);
            // variablen zurücksetzen
            unset($_POST["menge"]);
            unset($_POST["einheit"]);
            unset($_POST["preis"]);
            unset($_SESSION["mep_bearbeiten"]);
            // erfolgsmeldung an folgeseite übergeben.
            $_SESSION["erfolg"] ="Menge/Einheit/Preis wurden erfolgreich gespeichert";
            // umleiten auf die hauptseite
            header("location: speise_mep.php");
            exit();
        }
    }
}

if($fehler->fehlerAufgetreten()){
    echo $fehler->fehlerAusgabeHtml();
}
?>
<form method='post'>
    <div>
        <label class="form_beschriftung" for="menge">Menge: </label>
        <input autofocus type="number" step="0.01" min="0.01" name="menge" id="menge" value="<?php if (!empty( $_POST["menge"] )) {echo  punkt_statt_komma( zwei_kommastellen( $_POST["menge"])); } else if (!empty($mepDatensatz)){ echo punkt_statt_komma( zwei_kommastellen($mepDatensatz["menge"]));}  ?>">
    </div>
    <div>
        <label class="form_beschriftung" for="einheit">Einheit:</label>
        <select name="einheit" id="typ" size="3">
            <option value="" <?php if(empty($mepDatensatz) || empty($_POST["einheit"])) {echo ' selected ';} ?>>- Bitte wählen -</option>
            <?php
            foreach ($alleEinheiten as $einheit){
                echo "<option value='{$einheit->getSpalte("einheit_id")}'";
                  if(!empty($mepDatensatz) && $mepDatensatz["eid"]== $einheit->getSpalte("einheit_id")) {echo ' selected ';} else if (!empty( $_POST["einheit"] ) && $_POST["einheit"] == $einheit->getSpalte("einheit_id") ) {echo  " selected "; }
                  echo ">{$einheit->getSpalte("name")}</option>";
            }
            ?>
        </select>
    </div>
    <div>
        <label class="form_beschriftung" for="preis">Preis: </label>
        <input type="number" step="0.01" min="0.01" name="preis" id="preis" value="<?php if (!empty( $_POST["menge"] )) {echo  punkt_statt_komma( zwei_kommastellen( $_POST["preis"])); } else if (!empty($mepDatensatz)){ echo punkt_statt_komma( zwei_kommastellen($mepDatensatz["preis"]));} ?>">
    </div>
    <div>
        <label class="form_beschriftung" for="aktiv">Ist diese MEP aktiv? </label>
        <input type="checkbox" name="aktiv" id="aktiv" <?php if(!empty($mepDatensatz) && $mepDatensatz["aktiv"]=1) {echo " checked ";} else if (!empty( $_POST["aktiv"] )) {echo  " checked "; } ?> >
    </div>

    <button type="submit">MEP speichern</button>
</form>
<?php
include "fuss.php";