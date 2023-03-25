<?php
include "funktionen.php";
include "kopf.php";
?>
    <h1>Passagier liste</h1>
    <p>
        <a href="passagier_anlegen.php">Neuen Passagier anlegen</a>
    </p>


<?php
    $result=query("SELECT * from passagiere order by nachname ASC;");
    $result2=query("SELECT p.* , f.* FROM `passagiere` p, `fluege` f, `bz_passagier_zu_fluege` bz 
        WHERE f.id = bz.fluege_id AND p.passagier_id = bz.passagier_id order by p.nachname ASC;");
    $flug=fetch($result2);

    echo "<table border='1'>";
    echo "<thead>";
        echo "<th> Optionen </th> ";
        echo "<th> Vorname </th> ";
        echo "<th> Nachname </th> ";
        echo "<th> Geb. Datum </th> ";
        echo "<th> Flugangst </th> ";
        echo "<th> x </th> ";
        echo "<th> Flugnr. </th> ";
        echo "<th> Abflug </th> ";
        echo "<th> Ankunft </th> ";
        echo "<th> Start FH </th> ";
        echo "<th> Ziel FH </th> ";

    echo "<thead>";
    echo "<tbody>";
        while ($pas = fetch($result)) {
            echo "<tr>";
                echo "<td> <a href='passagier_bearbeiten.php?id=".$pas["passagier_id"]."'>Passagier bearbeiten</a> <br>
                    <a href='passagier_entfernen.php?id=".$pas["passagier_id"]."'>Passagier entfernen</a> <br>
                    <a href='flug_entfernen.php?id=".$pas["passagier_id"]."'>Flug entfernen</a>
                    </td>";                
                echo "<td>".$pas["vorname"]."</td>";
                echo "<td>".$pas["nachname"]."</td>";
                echo "<td>".$pas["geb_datum"]."</td>";
                echo "<td align='center'>"; if(!empty($pas["flugangst"])){
                    echo "Ja";
                } else {
                    echo "Nein";
                }
                echo "</td>";
                echo "<td>-</td>";

                while(!empty($flug) && $flug["passagier_id"]==$pas["passagier_id"]){
                    if(!empty($flug) && $flug["passagier_id"]==$pas["passagier_id"]){
                        echo "<td>".$flug["flugnr"]."</td>";
                        echo "<td>".$flug["abflug"]."</td>";
                        echo "<td>".$flug["ankunft"]."</td>";
                        echo "<td>".$flug["start_flgh"]."</td>";
                        echo "<td>".$flug["ziel_flgh"]."</td>";
                        $flug=fetch($result2);
                        if(!empty($flug) && $flug["passagier_id"]==$pas["passagier_id"]){
                            echo "</tr>";
                            echo "<tr>";
                            echo "<td>-</td>";
                            echo "<td>-</td>";
                            echo "<td>-</td>";
                            echo "<td>-</td>";
                            echo "<td>-</td>";
                            echo "<td>-</td>";
                        }
                    }else {
                        echo "<td>-</td>";
                        echo "<td>-</td>";
                        echo "<td>-</td>";
                        echo "<td>-</td>";
                        echo "<td>-</td>";
                    }
                }
                



            echo "</tr>";
        }
    echo "<tbody>";
    echo "</table>";
  

?>




<?php
include "fuss.php";
?>
