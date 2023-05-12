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


// sicherheitsüberprüfung ob die übergebene id existiert
if(!empty($_SESSION["mep_bearbeiten"])){
    $mepDatensatz = $bzMep -> getEinzelnenMep($_SESSION["mep_bearbeiten"]);
    $tun="bearbeiten";
} else {
    $tun="hinzufügen";
}

// echo'MepDatensatz:';
// echo"<pre>"; //print_r Inhalt aus einem Array darstellen (nur zum debuggen)
// print_r($mepDatensatz);
// echo "</pre>";

echo "<h1>Menge/Einheit/Preis {$tun} </h1>";

// Bearbeitete Kategorie wurde übergeben
if(!empty($_POST)){
    $fehler -> istAusgefuellt($_POST["menge"],"Menge");
    $fehler -> istAusgefuellt($_POST["einheit"],"Einheit");
    $fehler -> istAusgefuellt($_POST["preis"],"Preis");
    if(!empty($_POST["aktiv"])) $aktiv=1; else $aktiv=0;

    if(!$fehler->fehlerAufgetreten()){   //Felder dürfen nicht leer sein.
    //     $_POST["name"]=="" || $_POST["beschr"]==""){ 
    //     $fehlermeldung="Bitte alle Felder ausfüllen !";
    // } else 
   
        // überprüfen ob sich etwas geändert hat, bin mir nicht ganz sicher ob das sinnvoll/zweckmässig ist?
        
        $datensatz=array(
            "bz_sk_id" => $_SESSION["mep_bearbeiten"] ?? null,
                // if(!empty($_GET["id"])) {"id" => $_GET["id"]} else {"id" => null}
            // "speise_id" => $_SESSION["s_id_mep"],
            "kategorie_id" => $bzMep->getKatId(),
            "einheit_id" => $_POST["einheit"],
            "menge" => $_POST["menge"],
            "aktiv" => $aktiv,
            "preis" => $_POST["preis"]
            
        );

        echo'MepDatensatz:';
echo"<pre>"; //print_r Inhalt aus einem Array darstellen (nur zum debuggen)
print_r($datensatz);
echo "</pre>";
  

        // $sql_name=escape($_POST["name"]);
        // $sql_beschr=escape($_POST["beschr"]);
        // $sql_typ=escape($_POST["typ"]);
        // $sql = "SELECT * from kategorie where (`name` ='{$sql_name}' and `beschreibung`='{$sql_beschr}' and `typ`='{$sql_typ}') or 
        //     ((`name` ='{$sql_name}' or `beschreibung`='{$sql_beschr}') and `kategorie_id`!= {$sql_id} )";
        // if($result=$con->query($sql)){ 
            if(!$bzMep->mepVerschieden($datensatz) ){//abfragen ob die geänderten Daten, sich tatsächlich geändert haben oder die neue Kategorie bereits in der DB existiert (Name, Beschreibung)
                $fehler-> fehlerDazu("Diese Menge/Einheit/Preis existiert bereits oder es wurde nichts geändert!");
            } else {
                $bzMep -> speichern($datensatz);
                // $sql="UPDATE kategorie set `name`='$sql_name', `beschreibung`='$sql_beschr', `aktiv` = '$aktiv' , `typ` = '$sql_typ' where `kategorie_id`= {$sql_id}; ";
                
                // $result=$con->query($sql);

                // $erfolg="Die Kategorie wurde erfolgreich eingetragen.";
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
        // }

    }
}

if($fehler->fehlerAufgetreten()){
    echo "<p style='color:red'>".$fehler->fehlerAusgabeHtml()."</p>";

}
// if(!empty($erfolg)){
//     echo "<p style='color:green'>".$erfolg."</p>";
//     header("refresh:5; kategorie.php");
//     exit();
// }

// if (!empty( $_POST["menge"] )) {echo  zwei_kommastellen( $_POST["menge"]); }
// echo  "hallo".punkt_statt_komma( zwei_kommastellen( $_POST["menge"]))."hallo";
?>

<form method='post'>
    <div>
        <label class="form_beschriftung" for="menge">Menge: </label>
        <input type="number" step="0.01" min="0.01" name="menge" id="menge" value="<?php if (!empty( $_POST["menge"] )) {echo  punkt_statt_komma( zwei_kommastellen( $_POST["menge"])); } else if (!empty($mepDatensatz)){ echo punkt_statt_komma( zwei_kommastellen($mepDatensatz["menge"]));}  ?>">
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

            <?php
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
