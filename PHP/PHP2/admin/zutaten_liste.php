<?php
include "funktionen.php";
ist_eingeloggt();

include "kopf.php";
?>

<h1>Zutaten</h1>
<p>
    <a href="zutaten_neu.php">Neue Zutaten hinzufügen</a>
</p>


<?php
$result = query("SELECT * from `zutaten`");
// var_dump($result);

echo "<table border='1'>";
    echo "<thead>";
        echo "<th> ID </th> ";
        echo "<th> Titel </th> ";
        echo "<th> kcal/100 </th> ";
        echo "<th> Optionen </th> ";
    echo "<thead>";
    echo "<tbody>";
        while ($row = fetch($result)) {
            echo "<tr>";
                echo "<td>".$row["id"]."</td>";
                echo "<td>".$row["name"]."</td>";
                echo "<td>".$row["kcal_pro_100"]."</td>";
                echo "<td> <a href='zutaten_bearbeiten.php?id=".$row["id"]."'>bearbeiten</a> <br>
                    <a href='zutaten_entfernen.php?id=".$row["id"]."'>entfernen</a>
                </td>";
            echo "</tr>";
        }
       



    echo "<tbody>";
echo "</table>";

include "fuss.php";
