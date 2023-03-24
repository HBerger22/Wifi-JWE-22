<?php
include "funktionen.php";
ist_eingeloggt();

include "kopf.php";
?>

<h1>Rezepte</h1>
<p>
    <a href="rezepte_neu.php">Neues Rezept hinzufügen</a>
</p>


<?php
// $result = query("SELECT * from `zutaten`");
$result = query("SELECT `rezepte`.*, `benutzer`.benutzername FROM `rezepte` JOIN `benutzer` on `benutzer`.`id`=`rezepte`.`benutzer_id`;");

// var_dump($result);

echo "<table border='1'>";
    echo "<thead>";
        echo "<th> ID </th> ";
        echo "<th> Titel </th> ";
        echo "<th> Beschreibung </th> ";
        echo "<th> Benutzername </th> ";
        echo "<th> Optionen </th> ";
    echo "<thead>";
    echo "<tbody>";
        while ($row = fetch($result)) {
            echo "<tr>";
                echo "<td>".$row["id"]."</td>";
                echo "<td>".$row["titel"]."</td>";
                echo "<td>".$row["beschreibung"]."</td>";
                echo "<td>".$row["benutzername"]."</td>";
                echo "<td> <a href='rezept_bearbeiten.php?id=".$row["id"]."'>bearbeiten</a> <br>
                    <a href='rezept_entfernen.php?id=".$row["id"]."'>entfernen</a>
                </td>";
            echo "</tr>";
        }
       



    echo "<tbody>";
echo "</table>";

include "fuss.php";
