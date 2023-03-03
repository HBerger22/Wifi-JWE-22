<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP - Grundlagen 09 - For-Schleifen</title>
</head>
<body>
    <h1>For-Schleifen</h1>
    <?php
        //Das 1x1 von 1-10 in einer HTML darstellen.
        echo "<em><strong>For Schleife: Das 1x1 von 1-x in einer HTML darstellen.:<br>Zeile 6 ausblenden, <br>Alle Werte die durch 7 teilbar sind sollen ausgeblendet werden.</strong></em>"; 
        echo "<br>";

        $spalten=10; //anzahl spalten
        $zeilen=20; //anzahl zeilen
        echo '<table border="1">';
        for($i=1;$i<=$zeilen;$i++){
            if($i == 6) continue; //die 6. Zeile auslassen, rest der Schleife überspringen
            echo "<tr>";
                for($j=1;$j<=$spalten;$j++){
                    
                    echo '<td align="center" width="50px">';
                    if($j==$spalten){ //letzte spalte mit ... füllen
                        echo "...";
                    }else if($i * $j % 7 == 0){
                        echo " ";
                    }else {
                        echo $i*$j;
                    };
                    echo "</td>";
                }
            echo "<tr>";

        }
        echo '</table>';

    ?>

    <br><br>
    <table border="1">
        <tr>
            <td>1</td>
            <td>2</td>
            <td>3</td>
            <td>...</td>
        </tr>
        <tr>
            <td>2</td>
            <td>4</td>
            <td>6</td>
            <td>...</td>
        </tr>
        <tr>
            <td>3</td>
            <td>6</td>
            <td>9</td>
            <td>...</td>
        </tr>


    </table>
    
</body>
</html>