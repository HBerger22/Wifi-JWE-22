<?php

use WIFI\Fdb\Model\Row\Fahrzeug;
include "setup.php";
ist_eingeloggt();

include "kopf.php";
echo "<h1>Fahrzeug entfernen</h1>";

$fahrzeug = new Fahrzeug($_GET["id"]);

// hat der benutzer bereits bestätigt?
if(!empty($_GET["doit"])){ //ja
    // Fahrzeug löschen
    $fahrzeug->entfernen();
    echo "<p>Das Fahrzeug wurde erfolgreich gelöscht</p>";
    echo "<a href='fahrzeuge_liste.php'>Zurück zu Zutatenliste</a>";

} else {  // Benutzer Fragen ob er das Fahrzeug wirklich löschen will.
    echo "<h3> Wollen sie dieses Fahrzeug wirklich endgültig löschen?</h3>";
    echo "<strong>Marke:</strong> ".$fahrzeug->marke()->hersteller."<br>";
    echo "<strong>Marke:</strong> ".$fahrzeug->modell."<br>";
    echo "<strong>Marke:</strong> ".$fahrzeug->farbe."<br>";
    echo "<strong>Marke:</strong> ".$fahrzeug->fin."<br>";
    echo "<p> 
                <a href='fahrzeuge_liste.php'>Nein, abbrechen</a>
                <a href='fahrzeuge_entfernen.php?id={$fahrzeug->id}&amp;doit=1'>Ja, klar</a>
            </p>";
    
}

include "fuss.php";