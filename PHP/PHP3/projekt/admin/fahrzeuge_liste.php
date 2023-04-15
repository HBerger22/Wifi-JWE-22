<?php
include "setup.php";
ist_eingeloggt();

use WIFI\Fdb\Model\Fahrzeuge;
// use WIFI\Fdb\Model\Row\Fahrzeug;

include "kopf.php";
?>

<h1>Fahrzeuge</h1>
<p>
    <a href="fahrzeuge_bearbeiten.php">Neues Fahrzeug anlegen</a>
</p>

<?php
echo "<table border='1'>";
    echo "<thead>";
        echo "<th> Marke </th> ";
        echo "<th> Modell </th> ";
        echo "<th> Farbe </th> ";
        echo "<th> Fahrzeug Idendifikations Nummer (FIN) </th> ";
        echo "<th> Optionen </th> ";
    echo "<thead>";
    echo "<tbody>";

    // $fzg = new Fahrzeug(3);
    // echo $fzg->modell; // wäre das gleiche wie echo $fzg->__get("modell");
    // echo $fzg->farbe;
    // echo $fzg->sdfsd;

    $fzge = new Fahrzeuge();
    $alleFahrzzeuge = $fzge->alleFahrzeuge();

    foreach ( $alleFahrzzeuge as $auto ) {
        echo "<tr>";
            echo "<td>".$auto->marke()->hersteller."</td>";
            echo "<td>".$auto->modell."</td>";
            echo "<td>".$auto->farbe."</td>";
            echo "<td>".$auto->fin."</td>";
            echo "<td> <a href='fahrzeuge_bearbeiten.php?id=".$auto->id."'>bearbeiten</a> <br>
                 <a href='fahrzeuge_entfernen.php?id=".$auto->id."'>entfernen</a>
            </td>";
        echo "</tr>";
    }
    echo "<tbody>";
echo "</table>";

include "fuss.php";