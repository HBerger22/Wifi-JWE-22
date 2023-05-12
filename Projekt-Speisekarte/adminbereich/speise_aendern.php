<?php
include "setup.php";

use WIFI\SK\Model\Allergene;
use WIFI\SK\Model\BzAllergene;
use WIFI\SK\Model\BzKatEinheit;
use WIFI\SK\Model\Kategorien;
use WIFI\SK\Model\Row\Getraenk;
use WIFI\SK\Model\Row\Kat;
use WIFI\SK\Model\Row\Speise;
use WIFI\SK\Validieren;

include "kopf.php";

$fehler = new Validieren;

$kategorien= new Kategorien();
$alleKategorien = $kategorien -> alleElemente();

$bzKEP = new BzKatEinheit($_SESSION["objekt"]);
$bzA = new BzAllergene($_SESSION["objekt"]);

$allergene=new Allergene();
$alleAllergene=$allergene->alleElemente();

//speise oder Getränk
// if($_SESSION["objekt"]=="Speise"){
//     $objektId="speise_id";
// } else {
//     $objektId="getraenk_id";
// }
// sicherheitsüberprüfung ob die übergebene id existiert
if(!empty($_SESSION["s_bearbeiten"])){
    if($_SESSION["objekt"]=="Speise"){
        $speise = new Speise($_SESSION["s_bearbeiten"]);
    } else {
        $speise = new Getraenk($_SESSION["s_bearbeiten"]);
    }
    
    $aktiv=$speise->getSpalte("aktiv"); //benötigt zum speichern bei änderungen 
    // $bzKatExistiert = $bzKEP->alleElemente($speise->getSpalte("speise_id"));
    $bzKatExistiert = $bzKEP->zugehörigeKat($speise->getSpalte($objektId));
    $tun="bearbeiten";
} else {
    $bzKatExistiert=false;
    $aktiv=false;
    $tun="hinzufügen";
}


echo "<h1>{$_SESSION["objekt"]} {$tun} </h1>";

// Bearbeitete Speise wurde übergeben
if(!empty($_POST)){
    $fehler -> istAusgefuellt($_POST["name"],"Name");
    $fehler -> istAusgefuellt($_POST["beschr"],"Beschreibung");
    $fehler -> istAusgefuellt($_POST["kategorie"],"Kategorie");
    // if(!empty($_POST["aktiv"])) $aktiv=1; else $aktiv=0;
    

    if(!$fehler->fehlerAufgetreten()){   //Felder dürfen nicht leer sein.
         // überprüfen ob sich etwas geändert hat, bin mir nicht ganz sicher ob das sinnvoll/zweckmässig ist?
         if($_SESSION["objekt"]=="Speise"){
            $speise_neu = new Speise(array(
                $objektId => $_SESSION["s_bearbeiten"] ?? null,
                    // if(!empty($_GET["id"])) {"id" => $_GET["id"]} else {"id" => null}
                "name" => $_POST["name"],
                "beschreibung" => $_POST["beschr"],
                "aktiv" => $aktiv
            ));
        } else {
            $speise_neu = new Getraenk(array(
                $objektId => $_SESSION["s_bearbeiten"] ?? null,
                    // if(!empty($_GET["id"])) {"id" => $_GET["id"]} else {"id" => null}
                "name" => $_POST["name"],
                "beschreibung" => $_POST["beschr"],
                "aktiv" => $aktiv
            ));
        }
            
        // Allergene Check, hat sich bei den Allergenen etwas geändert?
        if(!empty($speise)){ 
            $allergenCheck=false;
            foreach ($alleAllergene as $allergen){
                $allergen->setTyp($objektId);
                if( $allergen->existiertVerbindungZuSpeise($speise->getSpalte($objektId)) == empty($_POST["allergen_{$allergen->getSpalte("klasse")}"])){
                    echo "allergen_{$allergen->getSpalte("klasse")} - true <br>";
                    $allergenCheck=true;
                    break;
                } 
            }
        }

        if(((!empty($allergenCheck)&& !$allergenCheck) && !empty($speise) && ($speise->objektVerschieden($speise_neu) && !$bzKEP->katVerschieden($_SESSION["s_bearbeiten"],$_POST["kategorie"]))) || ( empty($speise) && $speise_neu-> datensatzExistiertBereits())){//abfragen ob die übergebenen Daten, sich tatsächlich geändert haben oder die neue Kategorie bereits in der DB existiert (Name, Beschreibung)
                $fehler-> fehlerDazu("Diese {$_SESSION["objekt"]} existiert bereits oder es wurde nichts geändert!");
        } else {
            // speichern 

            $speiseId = $speise_neu -> speichern();
            // echo "Speise ID: ". $speiseId;

            // Kat speichern
            $bzKEP->speichernKat($speiseId,$_POST["kategorie"]);

            // allergene Speichern
            foreach ($alleAllergene as $allergen){
                $allergen->setTyp($objektId);
                if(!empty($_POST["allergen_{$allergen->getSpalte("klasse")}"])){
                    $allergen->verbindungSpeichern($speiseId,true);
                } else {
                    $allergen->verbindungSpeichern($speiseId,false);
                }
            }

            // variablen zurücksetzen
            unset($_POST["name"]);
            unset($_POST["beschr"]);
            unset($_SESSION["s_bearbeiten"]);
            // erfolgsmeldung an folgeseite übergeben.
            $_SESSION["erfolg"] ="{$_SESSION["objekt"]} wurde erfolgreich gespeichert";
            // umleiten auf die hauptseite
            header("location: speisen.php");
            exit();
        }

    }
}

if(!$alleAllergene){
    $fehler->fehlerDazu("Bitte legen sie noch die notwendigen Allergene an, bevor sie die/das Erste {$_SESSION["objekt"]} anlegen!");
}

if($fehler->fehlerAufgetreten()){
    echo "<p style='color:red'>".$fehler->fehlerAusgabeHtml()."</p>";

}
// if(!empty($erfolg)){
//     echo "<p style='color:green'>".$erfolg."</p>";
//     header("refresh:5; kategorie.php");
//     exit();
// }
?>

<form method='post'>
    <div>
        <label class="form_beschriftung" for="name"> <?php echo $_SESSION["objekt"] ?> namen: </label>
        <input type="text" name="name" id="name" value="<?php if(!empty($speise)){ echo $speise -> getSpalte("name");} else if (!empty( $_POST["name"] )) {echo  $_POST["name"]; } ?>">
    </div>
    <div>
        <label class="form_beschriftung" for="beschr"> Beschreibung: </label>
        <input type="text" name="beschr" id="beschr" value="<?php if(!empty($speise)){ echo $speise -> getSpalte("beschreibung");}else if (!empty( $_POST["beschr"] )) {echo  $_POST["beschr"]; } ?>">
    </div>




<?php
// echo"<pre>"; //print_r Inhalt aus einem Array darstellen (nur zum debuggen)
// print_r($bzKatExistiert);
// echo "</pre>";

?>



    <div><!-- Kategorie (Vorspeise, Suppe, ...))  -->
        <label class="form_beschriftung" for="kategorie">Kategorie:</label>
        <select name="kategorie" size="5">
            <option value="" <?php if(empty($speise) || empty($_POST["kategorie"])) {echo ' selected ';} ?>>- Bitte wählen -</option>
            <?php 
                // $bzKatExistiert = $bzKEP->zugehörigeKat($speise->getSpalte("speise_id"));
                foreach ($alleKategorien as $kat){
                    if( $kat->getSpalte("typ")==$_SESSION["objekt"] ){
                        echo "<option value='{$kat->getSpalte("kategorie_id")}'"; 
                        if(!empty($speise) && $bzKatExistiert && $bzKatExistiert [0]["kid"]== $kat->getSpalte("kategorie_id")) {echo ' selected ';} else if (!empty( $_POST["kategorie"] ) && $_POST["kategorie"] == $kat->getSpalte("kategorie_id") ) {echo  " selected "; } 
                        echo ">{$kat->getSpalte("name")}</option>";        
                    }
                }
            ?>
            
            <?php
           ?>
        </select>
    </div>
    <div>
        <h4>Allergene</h4>
        <?php
            if(!empty($alleAllergene)){
                $i=1;
                foreach($alleAllergene as $allergen){
                    $allergen->setTyp($objektId);
                    echo "<input type='checkbox' name='allergen_{$allergen->getSpalte("klasse")}' value='allergen_{$allergen->getSpalte("klasse")}'";
                    if((!empty($speise) && $allergen->existiertVerbindungZuSpeise($speise->getSpalte($objektId))) || !empty( $_POST["allergen_{$allergen->getSpalte("klasse")}"] )   ){ 
                        echo " checked ";
                    }
                    echo ">";
                    echo "<label for='allergen_{$allergen->getSpalte("klasse")}'> {$allergen->getSpalte("klasse")}: {$allergen->getSpalte("name")} </label>";
                    if ($i%2==0) echo " <br> ";
                    $i++;
                }
            }
        ?>

    </div>

    <!-- Checkbox mit Aktiv noch dazufügen () -->
    
    <button type="submit"> <?php $_SESSION["objekt"] ?> speichern</button>
</form>

<?php

include "fuss.php";