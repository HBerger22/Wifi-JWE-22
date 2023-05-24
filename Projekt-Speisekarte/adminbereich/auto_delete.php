<?php

use WIFI\SK\Model\Speisen;
use WIFI\SK\Model\Row\Speise;

include "setup.php";
// include "funktionen.php";


include "kopf.php";


echo "<h1>Willkommen im Verwaltungsbereich</h1>";


$objekt= new Speisen();
$alteElemente=$objekt->getProductsInactiveMinOneYear();

if(!$alteElemente){
    echo "Es wurden keine Elemente gefunden die seit mehr als 1 Jahr inaktiv gesetzt wurden.";
} else {
    if(empty($_POST["s_loeschen_bestaetigung"]) ){
        echo "<p style='color:red'>Wollen sie alle Produkteinträge aus der Datenbank, die seit mindestens 1 Jahr nicht mehr aktiviert waren, <br>
                <strong>endgültig</strong> löschen?!</p>";
        echo "<form method='post'>";
                echo '<button class="sub_buttons" type="submit" name="s_loeschen_bestaetigung" value="1">JA</button>';
                echo '<button class="sub_buttons" type="submit" name="s_loeschen_bestaetigung" value="0">NEIN</button>';
        echo "</form>";

        // liste der zu löschenden objekte
        foreach ($alteElemente as $speisen){
            echo "Produkt: ".$speisen["name"];
        }
    } else {
        if($_POST["s_loeschen_bestaetigung"] == 1 ){
            
            foreach ($alteElemente as $value){
                $speise= new Speise($value["speise_id"]);
                $speise -> bzLoeschen();
                $speise -> datensatzLoeschen();

            unset($_POST["s_loeschen_bestaetigung"]);
            echo "!!! Produkte erfolgreich gelöscht !!!";
            }
        }
    }
}  

// Ohne Userabfrage, für automatisches Script

// $objekt = new Speisen();
// $alteElemente=$objekt->getProductsInactiveMinOneYear();
// foreach ($alteElemente as $value){
//     $speise = new Speise($value["speise_id"]);
//     $speise -> bzLoeschen();
//     $speise -> datensatzLoeschen();
// }  

include "fuss.php";